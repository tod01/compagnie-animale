import mysql.connector
import pandas.io.sql as psql

class DataBaseConnect:

    def __init__(self, database):
        self.database = database
        self.connect()

    def connect(self):
        self.mydb = mysql.connector.connect(
            host="localhost",
            user="tod01",
            passwd="",
            database= self.database
        )
        mycursor = self.mydb.cursor()



    def get_data(self, table_name):

        sql_request = "SELECT * FROM " + table_name
        
        result = psql.read_sql(sql_request, self.mydb)

        return result

    def close_db(self):
        self.mydb.close()