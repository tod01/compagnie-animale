import ProfileManager as pM 
import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity

''' Content Based Recommender algorithm'''

class ContentBasedRecommender(pM.ProfileManager):
    
    MODEL_NAME = 'Content-Based'
    
    def __init__(self, recommendation_system, items_df=None):
        super(ContentBasedRecommender, self).__init__(recommendation_system)
        self.item_ids = recommendation_system.get_item_ids()
        self.items_df = items_df # used for verbose mode
        
    def get_model_name(self):
        return self.MODEL_NAME
        
    def _get_similar_items_to_user_profile(self, person_id, topn=100):
        #Computes the cosine similarity between the user profile and all item profiles
        
        users_profiles = super().build_users_profiles()

        cosine_similarities = cosine_similarity(users_profiles[person_id], super().get_tfidf_matrix())
        
        #Gets the top similar items
        similar_indices = cosine_similarities.argsort().flatten()[-topn:]

        #Sort the similar items by similarity
        similar_items = sorted([(self.item_ids[i], cosine_similarities[0,i]) for i in similar_indices], key=lambda x: -x[1])

        return similar_items
        
    def recommend_items(self, user_id, items_to_ignore=[], topn=10, verbose=False):
        #print("Welcome to the recommendation items")

        similar_items = self._get_similar_items_to_user_profile(user_id)

        #Ignores items the user has already interacted
        similar_items_filtered = list(filter(lambda x: x[0] not in items_to_ignore, similar_items))
        
        recommendations_df = pd.DataFrame(similar_items_filtered, columns=['postId', 'recStrength']) \
                                    .head(topn)

        if verbose:
            if self.items_df is None:
                raise Exception('"items_df" is required in verbose mode')

            recommendations_df = recommendations_df.merge(self.items_df, how = 'left', 
                                                          left_on = 'postId', 
                                                          right_on = 'postId')[['recStrength', 'postId', 'title', 'authorRegion', 'price']]

       
        return recommendations_df
