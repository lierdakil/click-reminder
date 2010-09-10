#include "qdatebutton.h"

QDateButton::QDateButton(QWidget *parent) :
    QPushButton(parent)
{
    setLastClicked(QDateTime::currentDateTime());
    connect(this,SIGNAL(clicked()),SLOT(selfClicked()));
    setAutoFillBackground(true);
    setCycleDays(1);
    timer.setInterval(1000);
    connect(&timer,SIGNAL(timeout()),SLOT(timerFired()));
    timer.start();
}

QDateButton::QDateButton(const QString &text, QWidget *parent):
    QPushButton(text, parent)
{
    setLastClicked(QDateTime::currentDateTime());
    connect(this,SIGNAL(clicked()),SLOT(selfClicked()));
    setAutoFillBackground(true);
    setCycleDays(1);
    timer.setInterval(1000);
    connect(&timer,SIGNAL(timeout()),SLOT(timerFired()));
    timer.start();
}

void QDateButton::setLastClicked(QDateTime datetime)
{
    lastclicked=datetime;
    setToolTip(datetime.toString(Qt::TextDate));
}

void QDateButton::selfClicked()
{
    setLastClicked(QDateTime::currentDateTime());
}

void QDateButton::setCycleDays(qint32 days)
{
    cycledays=days;
}

void QDateButton::timerFired()
{
    QDateTime nextclicked=lastclicked.addDays(cycledays);
    int cyclesecs=cycledays*3600*24;
    int secsleft=QDateTime::currentDateTime().secsTo(nextclicked);
    int red;
    int green;
    if(secsleft*2>cyclesecs)
    {
        //secsleft/cyclesecs=1/2 => red=255
        //secsleft/cyclesecs=1 => red=0
        red=510-510*secsleft/cyclesecs;
        green=255;
        red=red>255?255:red;
        red=red<0?0:red;
    }
    else
    {
        //secsleft/cyclesecs=1/2 => green=255
        //secsleft/cyclesecs=0 => green=0
        red=255;
        green=510*secsleft/cyclesecs;
        green=green>255?255:green;
        green=green<0?0:green;
    }
    setStyleSheet(QString("background-color: rgb(%1, %2, 0)").arg(red).arg(green));
    update();
}
