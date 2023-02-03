<?php
class Socks
{
    public function __construct(
        private int $count,
        private int $price
    )
    {
    }
    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

}
// Создаем интерфейс и три стратегии
interface PaymentInterface
{
    public function payment(): string;
}

class QiwiPayment implements PaymentInterface
{
    public function payment(): string
    {
        return "Оплата Qiwi";
    }
}


class WebMoneyPayment implements PaymentInterface
{
    public function payment(): string
    {
        return "Оплата WebMoney";
    }
}
class YandexPayment implements PaymentInterface
{
    public function payment(): string
    {
        return "Оплата Яндекс.Деньги";
    }
}

// Создаем объект Cart  в который внедряем стратегию метода оплаты
class Cart
{
    private array $socks = [];

    public function addToCart(Socks $socks): void
    {
        $this->socks[] = $socks;
    }

    /**
     * @return array
     */
    public function getSocks(): array
    {
        return $this->socks;
    }

    /**
     * @param PaymentInterface $payment
     * @param array $socks
     * @return string
     */
    public function payment(PaymentInterface $payment, array $socks): string
    {
        return $payment->payment();
    }

}

// Использование
$socks = new Socks(10, 150);
$cart = new Cart();
$cart->addToCart($socks);

echo $cart->payment(new QiwiPayment(), $cart->getSocks()) . PHP_EOL;
echo $cart->payment(new WebMoneyPayment(), $cart->getSocks()) . PHP_EOL;
echo $cart->payment(new YandexPayment(), $cart->getSocks()) . PHP_EOL;

