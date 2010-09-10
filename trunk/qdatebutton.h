#ifndef QDATEBUTTON_H
#define QDATEBUTTON_H

#include <QPushButton>
#include <QDateTime>
#include <QPaintEvent>
#include <QTimer>

class QDateButton : public QPushButton
{
Q_OBJECT
public:
    explicit QDateButton(QWidget *parent = 0);
    explicit QDateButton(const QString &text, QWidget *parent=0);

private:
    QDateTime lastclicked;
    qint32 cycledays;
    QTimer timer;

signals:

public slots:
    void setLastClicked(QDateTime datetime);
    void setCycleDays(qint32 days);
    void selfClicked();
    void timerFired();
};

#endif // QDATEBUTTON_H
