from main import sql


def progress(message, bot):
    text = f'''
    '''
    bot.send_message(message.chat.id, text)

    text = '''
    '''
    bot.send_message(message.chat.id, text)

def routes(message, bot):
    text = 'https://postamap.ru/admin/postomat?id=2756'
    bot.send_message(message.chat.id, text, disable_web_page_preview=True)

def routes_random(message, bot):
    text = f'https://postamap.ru/admin/postomat?id={sql.get_random()}'
    bot.send_message(message.chat.id, text, disable_web_page_preview=True)

def location(message, bot):
    bot.send_message(message.chat.id, f'Долгота: {message.location.longitude}, Широта {message.location.latitude}')
    bot.send_message(message.chat.id, f'Идеальное место для постамата:')
    id = sql.get_point(message.location.longitude , message.location.latitude)
    text = f'https://postamap.ru/admin/postomat?id={id}'
    bot.send_message(message.chat.id, text, disable_web_page_preview=True)
