from telebot import types
from data.dialog import notifications, menu

class ClassMarkup:
    def __init__(self):
        pass

    @staticmethod
    def get_markup(name=menu):
        if not name:
            name = menu
        if type(name) == list:
            markup = types.ReplyKeyboardMarkup()
            for el in name:
                markup.add(types.KeyboardButton(el))
            return markup
