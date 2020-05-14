import scipy
import sklearn
from nltk.corpus import stopwords
from sklearn.feature_extraction.text import TfidfVectorizer
import numpy as np 


def tfidf_search_engine():
    #Ignoring stopwords (words with no semantics) from French
    stopwords_list = stopwords.words('french')

    #Trains a model whose vectors size is 5000, composed by the main unigrams and bigrams found in the corpus, ignoring stopwords
    vectorizer = TfidfVectorizer(analyzer='word',
                        ngram_range=(1, 2),
                        min_df=0.003,
                        max_df=0.5,
                        max_features=5000,
                        stop_words=stopwords_list)
    return vectorizer

def get_tfidf_matrix(dataframe, vectorizer):
    return vectorizer.fit_transform(dataframe['title'] + "" + dataframe['description'])


class ProfileManager:

    def __init__(self, recommendation_system):
        self.ads_df = recommendation_system.get_ads_df()
        self.item_ids = recommendation_system.get_item_ids()
        self.interactions_train_df = recommendation_system.get_interactions_train_df()
        self.vectorizer = tfidf_search_engine()
        self.tfidf_matrix = get_tfidf_matrix(self.ads_df, self.vectorizer)

        #print("welcome in profile manager system")

    def get_tfidf_matrix(self):
        return self.tfidf_matrix
    
    ''' Content Based Recommender System '''
    def get_item_profile(self, item_id):

        idx = self.item_ids.index(item_id)
        item_profile = self.tfidf_matrix[idx:idx+1]
        return item_profile

    def get_item_profiles(self, ids):
        item_profiles_list = [self.get_item_profile(x) for x in ids]
        item_profiles = scipy.sparse.vstack(item_profiles_list)
        return item_profiles

    def build_users_profile(self, person_id, interactions_indexed_df):
        interactions_person_df = interactions_indexed_df.loc[person_id]
        user_item_profiles = self.get_item_profiles(interactions_person_df['postId'])
        
        user_item_strengths = np.array(interactions_person_df['eventStrength']).reshape(-1,1)
        #Weighted average of item profiles by the interactions strength
        user_item_strengths_weighted_avg = np.sum(user_item_profiles.multiply(user_item_strengths), axis=0) / np.sum(user_item_strengths)
        user_profile_norm = sklearn.preprocessing.normalize(user_item_strengths_weighted_avg)
        return user_profile_norm

    def build_users_profiles(self): 
        interactions_indexed_df = self.interactions_train_df[self.interactions_train_df['postId'] \
                                                    .isin(self.ads_df['id'])].set_index('personId')
        user_profiles = {}
        
        for person_id in interactions_indexed_df.index.unique():
            
            user_profiles[person_id] = self.build_users_profile(person_id, interactions_indexed_df)
        
        #print("end of building users profiles")
        
        return user_profiles

    

