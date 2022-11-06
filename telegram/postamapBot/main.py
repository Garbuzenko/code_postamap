# import os
# from pprint import pprint

# import telebot
import telebot

import methods
from DB import sql
# from data.data import Comands

sql = sql.SqlClass()
from data.data import Comands

token = '5685186393:AAEPpCGp_CTZ0DSGdKbFOBYRiBQJM1pktn8' #os.environ.get('BOT_TOKEN')
bot = telebot.TeleBot(token)

def handler(event, _):
    message = telebot.types.Update.de_json(event['body'])
    bot.process_new_updates([message])
    return {
        'statusCode': 200,
        'body': '!',
    }

@bot.message_handler(content_types='text')
def text(message):
    c = Comands(message.text)
    if c.sticker:
        bot.send_sticker(message.from_user.id, c.sticker)
    if c.answer:
        if 'Не знаю что ответить' == c.answer:
            bot.send_message(message.chat.id, message.text, reply_markup=c.markup)
        else:
            bot.send_message(message.chat.id,  c.answer, reply_markup=c.markup)
    if c.poll:
        bot.send_poll(message.chat.id, c.poll, c.options)
    if c.method:
        f = getattr(methods, c.method)
        f(message, bot)

@bot.message_handler(content_types='photo')
def text(message):
    bot.send_message(message.chat.id, f'Локация ')
    # bot.send_location(message.chat.id, latitude=55.684553, longitude=37.623548)


@bot.message_handler(content_types='location')
def text(message):
    methods.location(message, bot)

# ---------------- local testing ----------------

if __name__ == '__main__':
    bot.infinity_polling()




