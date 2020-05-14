# This Python 3 environment comes with many helpful analytics libraries installed
# It is defined by the kaggle/python docker image: https://github.com/kaggle/docker-python
# For example, here's several helpful packages to load in 

import numpy as np # linear algebra
import pandas as pd # data processing, CSV file I/O (e.g. pd.read_csv)

# Input data files are available in the "../input/" directory.
# For example, running this (by clicking run or pressing Shift+Enter) will list all files under the input directory

# Any results you write to the current directory are saved as output.

import math
import random
#from nltk.corpus import stopwords
from sklearn.model_selection import train_test_split
#import nltk
#nltk.download('stopwords')

def random_dates(start, end, n=10):

    start_u = start.value//10**9
    end_u = end.value//10**9

    return pd.to_datetime(np.random.randint(start_u, end_u, n), unit='s')



class RecommendationSystem:

    def __init__(self, interactions_df, ads_df):
        self.ads_df = ads_df
        self.configuration(interactions_df)

    
    def get_item_ids(self):
        return self.ads_df['id'].tolist()

    def get_ads_df(self):
        return self.ads_df

    def  get_interactions_test_df(self):
        return self.interactions_test_df

    

    def configuration(self, interactions_df):


        #TODO: manage the part so that it won't execute every time 

        users_interactions_count_df = interactions_df.groupby(['personId', 'postId']).size().groupby('personId').size()
        #print("# users: %d "%len(users_interactions_count_df))
        users_with_enough_interactions_df = users_interactions_count_df[users_interactions_count_df >= 5].reset_index()[['personId']]
        #print("# users with at least 5 interactions: %d" % len(users_with_enough_interactions_df))

        interactions_from_selected_users_df = interactions_df.merge(users_with_enough_interactions_df,
                                                           how= 'right',
                                                           left_on ='personId',
                                                           right_on='personId',
                                                            
                                                           )
        
        #print("# of interactions from users with at least 5 interactions: %d" % len(interactions_from_selected_users_df))
        #TODO: not use userRegion but ads position
        interactions_full_df = interactions_from_selected_users_df.groupby(['personId', 'postId'])['eventStrength'].sum().apply(self.smooth_user_preference).reset_index()
        #print('# of unique user/item interactions: %d' % len(interactions_full_df))
        #interactions_full_df.head(10)
        #print(interactions_full_df.shape)
        #print("# of classes ", len(np.unique(interactions_full_df['personId'])))
        
        interactions_train_df, interactions_test_df = train_test_split(interactions_full_df, stratify=interactions_full_df['personId'], test_size=0.39, random_state=42)

        #print("# interactions on Train set: %d" % len(interactions_train_df))
        #print("# interactions on Test set: %d" % len(interactions_test_df))

        self.interactions_full_df = interactions_full_df
        self.interactions_train_df= interactions_train_df
        self.interactions_test_df = interactions_test_df
        self.interactions_df      = interactions_df
        self.interactions_train_indexed_df = interactions_train_df.set_index('personId')
    
    def get_interactions_train_indexed_df(self):
        return self.interactions_train_indexed_df

    def get_interactions_full_df(self):
        return self.interactions_full_df

    def get_interactions_train_df(self):
        return self.interactions_train_df
    
    def user_has_enough_interactions(self, user_id):
        return user_id in self.get_interactions_train_indexed_df().index
    

    def smooth_user_preference(self, x):
        return math.log(1+x, 2)

    def get_interactions_df(self):
        return self.interactions_df

    