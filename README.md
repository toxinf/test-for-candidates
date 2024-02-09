# Запросы для теста
## Расчёт цены
```
curl -X POST http://127.0.0.1:8880/calculate-price \
     -H "Content-Type: application/json" \
     -d '{"product": 1, "taxNumber": "DE123456789", "couponCode": "D15"}'
```
## Выполнение покупки
```
curl -X POST http://127.0.0.1:8880/purchase \
     -H "Content-Type: application/json" \
     -d '{"product": 1,"taxNumber": "IT12345678900","couponCode": "D15","paymentProcessor": "paypal"}'
```