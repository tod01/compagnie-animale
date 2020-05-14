import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.feature_extraction.text import TfidfVectorizer
import numpy as np
import sys 
import json
import ProfileManager as pf
import DataBaseConnect as db

class SearchEngine:

    def tf_idf(self, search_keys, dataframe):
        
        vectorizer = pf.tfidf_search_engine()
        tfidf_weights_matrix = pf.get_tfidf_matrix(dataframe, vectorizer)
        search_query_weights = vectorizer.transform([search_keys]) 
        
        return search_query_weights, tfidf_weights_matrix



    def cos_similarity(self, search_query_weights, tfidf_weights_matrix):
        
        cosine_distance = cosine_similarity(search_query_weights, tfidf_weights_matrix)
        similarity_list = cosine_distance[0]
        
        return similarity_list

    def most_similar(self, similarity_list):
        
        most_similar = []

        while True:
            tmp_index = np.argmax(similarity_list)
            if(tmp_index <= 0):
                break
            most_similar.append(tmp_index)
            similarity_list[tmp_index] = 0
            
        return most_similar

    def search(self, search_query, dataframe):
    # get tf_idf 
        search_query_weights, tfidf_weights_matrix = self.tf_idf(search_query, dataframe)
        similarity_list = self.cos_similarity(search_query_weights, tfidf_weights_matrix)
        
        most_sim = self.most_similar(similarity_list)
     
        return dataframe['id'].iloc[most_sim]

if __name__ == "__main__":

    if len(sys.argv) < 3:
        raise Exception ('You must provide the data ')

    query = sys.argv[1]
    
    database = db.DataBaseConnect("compagnie")

    ads = database.get_data("ads")

    search_engine = SearchEngine()
    
    result = search_engine.search(query, ads)

    database.close_db()

    print(result.to_json())

