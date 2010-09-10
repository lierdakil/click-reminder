#include "mainwindow.h"
#include "ui_mainwindow.h"
#include "qdatebutton.h"
#include <QInputDialog>

MainWindow::MainWindow(QWidget *parent) :
    QMainWindow(parent),
    ui(new Ui::MainWindow)
{
    ui->setupUi(this);
}

MainWindow::~MainWindow()
{
    delete ui;
}

void MainWindow::changeEvent(QEvent *e)
{
    QMainWindow::changeEvent(e);
    switch (e->type()) {
    case QEvent::LanguageChange:
        ui->retranslateUi(this);
        break;
    default:
        break;
    }
}

void MainWindow::on_actionAdd_triggered()
{
    QString text = QInputDialog::getText(this,"Enter name for new item", "Item name");
    qint32 cycledays = QInputDialog::getInt(this,"Set cycle days", "Cycle Days",0);
    QDateButton *button=new QDateButton(text,this);
    button->setCycleDays(cycledays);
    ui->gridLayout->addWidget(button);
}
