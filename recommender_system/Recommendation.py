#!/usr/bin/env python

import sys


# This Python 3 environment comes with many helpful analytics libraries installed
# It is defined by the kaggle/python docker image: https://github.com/kaggle/docker-python
# For example, here's several helpful packages to load in 

import numpy as np # linear algebra
import pandas as pd # data processing, CSV file I/O (e.g. pd.read_csv)

# Input data files are available in the "../input/" directory.
# For example, running this (by clicking run or pressing Shift+Enter) will list all files under the input directory

# Any results you write to the current directory are saved as output.


#import nltk
#nltk.download('stopwords')

import RecommendationSystem as recommender 

import CollaborativeFilteringRecommender as collaborativeFR
import ContentBasedRecommender as contentBR
import HybridRecommender as hybrid
import PopularityRecommender as popularity
import ModelEvaluator as evaluator
import DataBaseConnect as db

class Recommendation:
    
    def __init__(self, algorithm, df, ads_df, location, user=None):
        
        self.algorithm = algorithm
        self.ads_df = ads_df
        self.df = df 
        self.user = user

        self.location = location
        self.recommendation_sytem = recommender.RecommendationSystem(df, ads_df)
        self.evaluator = evaluator.ModelEvaluator(self.recommendation_sytem)
        
    def get_algorithm(self):

        return self.algorithm

    def model_evaluator(self, model):
        ''' Model evaluator '''


        evaluate_current_model = self.evaluator
        
        print('Evaluating Popularity recommendation model....')
        pop_global_metrics, pop_detailed_results_df = evaluate_current_model.evaluate_model(model)
        print('\nGlobal metrics: \n%s ' % pop_global_metrics)
        print(pop_detailed_results_df.head(10))

    def items_to_ignore(self, items):

        #TODO: we will use ads location, not userRegion
        
        '''if(self.location != "unknown"):
            return items[items['userRegion'] != self.location]
        '''
        data = {'postId' : []}
        return pd.DataFrame(data)
    
    def launcher(self):

        # if the popularity algorithm is chosen or the user has not enough interactions (it is a new user for example)
        if self.get_algorithm() == 'Popularity' or not self.recommendation_sytem.user_has_enough_interactions(self.user):
            #print("In popularity algorithm")
            
            # Computes the most popular items
            #print(self.recommendation_sytem.get_interactions_full_df().head())
            
            item_popularity_df = self.recommendation_sytem.get_interactions_full_df().groupby(['postId'])['eventStrength'].sum().sort_values(ascending=False).reset_index()
            #item_popularity_df.head(10)
            
            current_algo = popularity.PopularityRecommender(item_popularity_df, self.ads_df)
            
            recommendations_df = current_algo.recommend_items(None, self.items_to_ignore(item_popularity_df), item_popularity_df.shape[0], False)
            
            
        elif self.get_algorithm() == 'Hybrid':
            current_algo = hybrid.HybridRecommender(contentBR.ContentBasedRecommender(self.recommendation_sytem, None), \
                                                    collaborativeFR.CFRecommender(self.recommendation_sytem, None), \
                                                    self.ads_df,\
                                                    cb_ensemble_weight=1.0, cf_ensemble_weight=100.0)
            items_to_ignore = self.evaluator.get_items_interacted(self.user, self.recommendation_sytem.get_interactions_train_indexed_df())

            recommendations_df = current_algo.recommend_items(self.user, items_to_ignore, 1000000, False)

        elif self.get_algorithm() == 'Content-Based':
            #print("In content based algorithm")
            current_algo = contentBR.ContentBasedRecommender(self.recommendation_sytem, None)
            #print(type())
            interacted_items = self.evaluator.get_items_interacted(self.user, self.recommendation_sytem.get_interactions_train_df())
            print(interacted_items)
            quit()
            recommendations_df = current_algo.recommend_items(self.user, items_to_ignore=interacted_items,topn= 10000000000, verbose=False)

        elif self.get_algorithm() == 'Collaborative Filtering':
            current_algo = collaborativeFR.CFRecommender(self.recommendation_sytem, None)
            recommendations_df = current_algo.recommend_items(self.user, [], 10000000, False)
        else:
            raise Exception ("This algorithm doesn't take in account !")

        #self.model_evaluator(current_algo)
        print(recommendations_df['postId'].to_json())


def main():

    if len(sys.argv) < 3:
        raise Exception ('You must provide the data ')
    
    # check after how to use data without saving it in a file
    #x=sys.argv[1]
    #data = json.loads(x)
    #print(json.dumps("data"))

    #print(x[0].replace("[]",""))
    
    '''basePath = os.getcwd() + '/tmp/post.csv'
    with open(basePath) as file:
        data = csv.reader(file)
    '''
    #print(pd.DataFrame(data))
    #df = pd.read_csv(data)

    database = db.DataBaseConnect("compagnie")

    interactions = database.get_data("interactions")
    ads_df = database.get_data("ads")

    algorithm = sys.argv[1]
    user_id = sys.argv[2]
    location= sys.argv[3]
    
    recommendation = Recommendation(algorithm, interactions, ads_df, location, user_id)

    # recommend 
    recommendation.launcher()

    
    
if __name__ == "__main__":
    main()