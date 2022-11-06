import requests

class ApiClass(object):
    def __init__(self, access_token=None):
        self.access_token = access_token
        self.API_URL = ''

    def get_json(self):
        method = '?method=institution&type=1&limit=1'
        url = self.API_URL + method
        params = {}
        res = requests.get(url, params=params)
        return res.json()

    @staticmethod
    def get_max_url(item):
        max_height = -1
        res = ""
        for s in item['sizes']:
            if s['height'] > max_height:
                max_height = s['height']
                res = s['url']
        return res
