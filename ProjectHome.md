# Disclamer #

Click-reminder is still in backend implementation stage. There is no frontend as of yet, and backend specifications may change. You are welcome to discuss those though, if you are interested in the project.

# What? #

Click-reminder is a Web2.0 application aimed at users tending to forget when they last did something. It may be anything, from going to dentist to feeding your parrot. The aim is to remind users, when they last did it.

# Why? #

Think back, on how many times have you forgotten to buy new toothbrush two months after the old one? Or to pay your bills? Or to chagre your audio player? Click-reminder aims to address this issues, reminding you to do your periodic chores.

# How? #

Click-reminder operates the conception of 'reminders'. Reminder is a short note, possibly with a longer description, not unlike those sticky notes we all tried putting on the fridge. Interesting thing about reminder that it remembers last time you 'clicked' on it, which makes marking things as 'ok for a while' almost instant.

Optionally, color feedback may be enabled, if user specifies 'aging' rate for the reminder. Color may be reset in case reminder have fullfilled its purpose for the time being, or reminder may be removed altogether if it is not required anymore.

To summarize, click-reminder shows you the most urgent reminders, optionally using color feedback, reminders become more urgent as they age, and click-reminder allows to reset reminder with a single click.

# Tech details #

Since click-reminder is designed with Web2.0 concepts in mind, it consists of PHP5 backend whith MySQL5 as a storage, and AJAX frontend. Request-reply protocols, DB schema and flowcharts are readily available in our Wiki.