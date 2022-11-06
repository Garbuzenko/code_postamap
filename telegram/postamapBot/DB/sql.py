import sqlalchemy
# import pymysql

class SqlClass:
    db = 'mysql+pymysql://u1707968_default:HejHsi7dmB8E8NF5@31.31.196.62:3306/u1707968_default'
    def __init__(self):
        self.engine = sqlalchemy.create_engine(self.db)
        self.connection = self.engine.connect()

    def get_point(self, lng0, lat0):
        print('QUERY')
        sql = f"""      
        SELECT id, lat, lng, (ABS(lat - {lat0}) + ABS(lng - {lng0})) AS distance
        FROM postamats WHERE SQ_DIAMETR=400 HAVING distance < 0.05 ORDER BY distance;
        """
        print(sql)
        result = self.connection.execute(sql)
        for row in result:
            return row["id"]
        return 0


    def get_random(self):
        print('QUERY')
        sql = """
          SELECT id FROM postamats ORDER BY RAND() LIMIT 1;
          """
        result = self.connection.execute(sql).fetchall()
        return result[0][0]
