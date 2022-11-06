menu = ['Геопозиция', 'Случайный']

#Команды
dialog = {
    '/routes_random': {'reqest': ['Случайный'],
             'sticker': 'CAACAgIAAxkBAAEF6lljLi32R9rWUTElyH_XlVwT5EBO2QACixUAAu-iSEvcMCGEtWaZoCkE',
             'method': 'routes_random',
             'markup': menu},

    '/routes': {'reqest': [ 'Район'],
                       'sticker': 'CAACAgIAAxkBAAEF6l1jLjF2188KmZ_RZd3m7IeerGOCEwACxzEAAmOLRgwCYULS6Vs3vykE',
                       'method': 'routes',
                       'markup': menu},

    '/location': {'reqest': ['Геопозиция'],
                'answer': ['Отправьте свою геопозицию и я найду постаматы рядом'],
                'sticker': 'CAACAgIAAxkBAAEF6nVjLj2eaW4hZ3MRRNxhmUDEkPlbiQAC0zEAAmOLRgydd416JKnVvykE',
                'markup': menu},

    '/run': {'reqest': ['🚀 Давай начнём'],
               'answer': ['Выбери команду из меню'],
               'sticker': 'CAACAgIAAxkBAAEF6ohjLkGv8q6NIpfnfNHQEj_NHugyYQACfRoAAulVBRim1iHREUvE4ykE',
               'markup': menu},

    '/help': {'reqest': ['help', 'Помощь', '💪 Расскажи о себе'],
              'answer': ['Привет, я помогу тебе найти информацию о постаматах Москвы'],
              'sticker': 'CAACAgIAAxkBAAEF6lFjLiqOEgUhNymxtUZxxa9mdzzC3QACzxUAAnNXEEqubZupoZ0CDSkE',
              'key': 'favorites'},

    '/start': {'reqest': ['start', 'старт'],
              'answer': ['Добро пожаловать! Я помогу расположить постаматы Москвы'],
              'sticker': 'CAACAgIAAxkBAAEE9vdipDcTvbWn94_Xqmw-O8QuTO1eMAACqgYAAtJaiAFIBau3svuQYSQE',
              'key': 'favorites',
              'markup': ['🚀 Давай начнём', '💪 Расскажи о себе']},


    '/poll': {'reqest': ['опрос'],
              'answer': '',
              'poll': 'Оцените, пожалуйста',
              'sticker': 'CAACAgIAAxkBAAEE-LJipOQmNFJYR4epzAFU4jM4QFtQKAAChxUAAj0PUEnem2b91sejvyQE',
              'key': 'poll',
              'options': ['😍 Отлично', '😊 Хорошо', '😌 Норм', '😐 Плохо', '😔 Очень плохо'],
              },

    '/notifications': {'reqest': ['уведомления'],
              'answer': ['Уведомления'],
              'sticker': 'CAACAgIAAxkBAAEE9vdipDcTvbWn94_Xqmw-O8QuTO1eMAACqgYAAtJaiAFIBau3svuQYSQE',
              'key': 'favorites',
            },

    'none': { 'reqest': ['none'],
              'answer': ['Не знаю что ответить'],
              'sticker': 'CAACAgIAAxkBAAEE9vdipDcTvbWn94_Xqmw-O8QuTO1eMAACqgYAAtJaiAFIBau3svuQYSQE',
              'key': 'favorites',
              },

}

# ---------------- notification ----------------
notifications = ['Локация',
                 'Напоминание',
                 'Поздравление',
                 'Оценить']