from scipy.sparse import csr_matrix
from scipy.sparse.linalg import svds
import numpy as np # linear algebra
import pandas as pd # data processing, CSV file I/O (e.g. pd.read_csv)

'''Collaborative Filtering model'''

class CFRecommender:
    
    MODEL_NAME = 'Collaborative Filtering'
    
    def __init__(self, recommendation_sytem, items_df=None):
        #print("Welcome to collaborative filtering recommender")
        self.cf_predictions_df = self.collaborativeFR_config(recommendation_sytem.get_interactions_train_df())
        self.items_df = items_df
        
    def get_model_name(self):
        return self.MODEL_NAME

    
    def collaborativeFR_config(self, interactions_train_df):
         # Creating a sparse pivot table with users in rows and items in columns
        
        #users_items_pivot_matrix_df = interactions_train_df.pivot(index='personId', columns='postId', values='eventStrength').fillna(0)
        users_items_pivot_matrix_df = pd.pivot_table(interactions_train_df, index='personId', columns='postId').fillna(0)
        users_items_pivot_matrix = users_items_pivot_matrix_df.values
        users_ids = list(users_items_pivot_matrix_df.index)

        #Compressed Sparse Row matrix
        users_items_pivot_sparse_matrix = csr_matrix(users_items_pivot_matrix)
       
        # The number of factors to factor the user-item matrix.
        NUMBER_OF_FACTORS_MF = 15
        # Performs matrix factorization of the original user item matrix
        #U, sigma, Vt = svds(users_items_pivot_matrix, k = NUMBER_OF_FACTORS_MF)
        U, sigma, Vt = svds(users_items_pivot_sparse_matrix, k = NUMBER_OF_FACTORS_MF)
      
        sigma = np.diag(sigma)
       
        all_user_predicted_ratings = np.dot(np.dot(U, sigma), Vt)
        all_user_predicted_ratings_norm = (all_user_predicted_ratings - all_user_predicted_ratings.min()) / (all_user_predicted_ratings.max() - all_user_predicted_ratings.min())
        # Converting the reconstructed matrix back to a Pandas dataframe
        cf_preds_df = pd.DataFrame(all_user_predicted_ratings_norm, columns = users_items_pivot_matrix_df.columns, index=users_ids).transpose()
        #cf_preds_df.head(10)
        
        return cf_preds_df


        
    def recommend_items(self, user_id, items_to_ignore=[], topn=10, verbose=False):
        # Get and sort the user's predictions
        sorted_user_predictions = self.cf_predictions_df[user_id].sort_values(ascending=False) \
                                    .reset_index().rename(columns={user_id: 'recStrength'})

        # Recommend the highest predicted rating movies that the user hasn't seen yet.
        recommendations_df = sorted_user_predictions[~sorted_user_predictions['postId'].isin(items_to_ignore)] \
                               .sort_values('recStrength', ascending = False) \
                               .head(topn)

        if verbose:
            if self.items_df is None:
                raise Exception('"items_df" is required in verbose mode')

            recommendations_df = recommendations_df.merge(self.items_df, how = 'left', 
                                                          left_on = 'postId', 
                                                          right_on = 'postId')[['recStrength', 'postId', 'title', 'authorRegion', 'price']]


        return recommendations_df
  