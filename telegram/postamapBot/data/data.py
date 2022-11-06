import random

from data.dialog import dialog
from interface.markup import ClassMarkup

class Comands(object):
    answer: str = ''
    sticker: str = ''
    key: str = ''
    poll: str = ''
    options: []

    # инициализация класса
    def __init__(self, name):
        d = self.get_comand(name)
        if d.get('answer'):
            self.answer = random.choice(d.get('answer'))
        self.sticker = d.get('sticker')
        self.key = d.get('key')
        self.markup = ClassMarkup.get_markup(d.get('markup'))
        self.poll = d.get('poll')
        self.options = d.get('options')
        self.method = d.get('method')

    @staticmethod
    def get_comand(name):
        for c in dialog:
            el = dialog[c]
            if name in el.get('reqest') or name.lower() in el.get('reqest') or name.lower() == c:
                break
        comand = dialog.get(c)
        return comand



