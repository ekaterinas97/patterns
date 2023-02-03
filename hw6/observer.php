<?php
interface ObserverInterface
{
    public function update(ObservableInterface $observable);
}
interface ObservableInterface
{
    // Добавление нового наблюдателя
    public function attach(ObserverInterface $observer);

    // Удаление имеющегося наблюдателя
    public function detach(ObserverInterface $observer);

    // Оповещение всех наблюдателей через вызов у него метода update
    public function notify();
}

class Vacancy implements ObservableInterface
{
    private array $observers = [];

    private string $name;

    public function attach(ObserverInterface $observer)
    {
        foreach ($this->observers as $object){
            if($object === $observer){
                return false;
            }
        }
        $this->observers[] = $observer;
        return true;
    }

    public function detach(ObserverInterface $observer)
    {
        foreach ($this->observers as $key => $object){
            if($observer === $object){
                unset($this->observers[$key]);
                return true;
            }
        }
        return false;
    }

    public function notify()
    {
        foreach ($this->observers as $observer){
            $observer->update($this);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        $this->notify();
    }
}

class Hunter1 implements ObserverInterface
{
    public function __construct(
        private string $name
    )
    {
    }
    private string $currentVacancy;

    public function update(ObservableInterface $observable)
    {
        $this->currentVacancy = $observable->getName();
        $this->display();
    }

    public function display()
    {
        echo $this->name . ": Вакансия -  " . $this->currentVacancy . PHP_EOL;
    }
}
class Hunter2 implements ObserverInterface
{
    public function __construct(
        private string $name
    )
    {
    }

    private string $currentVacancy;

    public function update(ObservableInterface $observable)
    {
        $this->currentVacancy = $observable->getName();
        $this->display();
    }

    public function display()
    {
        echo $this->name . ": Вакансия -  " . $this->currentVacancy . PHP_EOL;
    }
}

$h1 = new Hunter1('Иван');
$h2 = new Hunter2('Николай');
$h3 = new Hunter1('Петр');
$vacancy = new Vacancy();

$vacancy->attach($h1);
$vacancy->attach($h2);
$vacancy->attach($h3);
$vacancy->setName('New vacancy');
$vacancy->setName('PHP-programmer');
$vacancy->detach($h1);
$vacancy->setName('Frontend developer');




