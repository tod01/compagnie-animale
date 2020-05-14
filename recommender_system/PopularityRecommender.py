   
''' Popularity recommender system'''

import socket
import requests
import json
import pandas as pd

class PopularityRecommender():
    
    MODEL_NAME = 'Popularity'
    
    def __init__(self, popularity_df, items_df=None):
        #print("Welcome in popularity algorithm")
        self.popularity_df = popularity_df
        self.items_df = items_df
        
    def get_model_name(self):
        return self.MODEL_NAME
        
    def recommend_items(self, user_id, items_to_ignore=[], topn=10, verbose=False):
        # Recommend the more popular items that the user hasn't seen yet.

        recommendations_df = self.popularity_df[~self.popularity_df['postId'].isin(items_to_ignore['postId'])] \
                               .sort_values('eventStrength', ascending = False) \
                               .head(topn)
        
        '''with pd.option_context('display.max_rows', None, 'display.max_columns', None):  # more options can be specified also
            print(recommendations_df)
        '''
        if verbose:
            if self.items_df is None:
                raise Exception('"items_df" is required in verbose mode')

            recommendations_df = recommendations_df.merge(self.items_df, how = 'left', 
                                                          left_on = 'postId', 
                                                          right_on = 'id')[['id', 'description', 'title', 'user_position', 'price']]

        return recommendations_df