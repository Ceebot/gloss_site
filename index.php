<? require_once 'php/header.php' ?>

<section class="hero">
    <div class="container hero__container">
        <div class="hero__content">
            <h1 class="hero__heading">
                Парикмахерская Глянец
            </h1>
            <p class="hero__description">
                Ищите своего мастера в Горняке? В парикмахерской «Глянец» мужские стрижки — 300 рублей, женские —
                350. Укладка от 500! Мы ждем вас в будние дни с 9.00 до 18.00, в субботу до 14.00 по адресу:
            <address class="hero__info ">Горняк, улица Маяковского, 132 А</address>
            <a class="hero__info" href="tel:+79609555599">Запись по телефону: +7 (960) 955-55-99</a>
            </p>
            <div class="hero__action">
                <a href="#section-form" class="hero__btn">Записаться</a>
            </div>
        </div>
    </div>
</section>

<section class="do" id="section-do">
    <div class="container">
        <h2 class="section-heading text-center">
            Товары и услуги
        </h2>
        <p class="do__description text-center">
            Ознакомьтесь со всеми видами наших услуг и уникальными товарами.
        </p>

        <?
        $services = [];
        $items = $mysql->query("SELECT * FROM service");
        while ($service = $items->fetch_assoc()) {
            $services[] = [
                'id' => $service['id'],
                'title' => $service['title'],
                'description' => $service['description'],
                'price' => $service['price'],
                'img' => $service['img'],
            ];
        }
        echo vueTag('vue-services', ['services' => $services]);
        ?>

        <div class="do__promotional">
            <div class="do__promotional-text">
                <p class="do__promotional-desc">Профессиональная</p>
                <h2 class="do__promotional-heading">Косметика для волос</h2>
                <h2 class="do__promotional-brand">INTENSIVE</h2>
                <?
                $products = [];
                $items = $mysql->query("SELECT * FROM product");
                while ($item = $items->fetch_assoc()) {
                    $products[] = [
                        'id' => $item['id'],
                        'title' => $item['title'],
                        'volume' => $item['volume'],
                        'price' => $item['price']
                    ] ?>
                    <?
                }
                echo vueTag('vue-popup-products', ['products' => $products]);
                ?>
            </div>
            <img class="do__promotional-img" src="img/intensive.png" alt="Товары intensive">
        </div>
    </div>
</section>

<section class="contacts" id="section-contacts">
    <div class="container">
        <h2 class="section-heading">
            Контакты
        </h2>
        <div class="contacts__container">
            <ul class="contacts__list">
                <li class="contacts__item">
                    <div class="contacts__gps contacts__div">
                        <strong class="contacts__heading">Адрес</strong>
                    </div>
                    <address class="contacts__info ">Горняк, улица Маяковского, 132 А
                    </address>
                </li>
                <li class="contacts__item">
                    <div class="contacts__phone contacts__div">
                        <strong class="contacts__heading">Телефон</strong>
                    </div>
                    <div class="contacts__info">
                        <a href="tel:+79609555599" class="contacts__link">+7 (960) 955-55-99</a>
                    </div>
                </li>
                <li class="contacts__item">
                    <div class="contacts__mail contacts__div">
                        <strong class="contacts__heading">Почта</strong>
                    </div>
                    <div class="contacts__info">
                        <a href="mailto:Natanovik987@mail.ru" class="contacts__link">Natanovik987@mail.ru</a><br>
                    </div>
                </li>
            </ul>

            <div class="contacts__map" style="position:relative;overflow:hidden;">
                <div style="position:relative;overflow:hidden;"><a
                            href="https://yandex.ru/maps/org/glyanets/124969761230/?utm_medium=mapframe&utm_source=maps"
                            style="color:#eee;font-size:12px;position:absolute;top:0px;">Глянец</a>
                    <a href="https://yandex.ru/maps/11239/gornyak/category/hairdressers/184105812/?utm_medium=mapframe&utm_source=maps"
                       style="color:#eee;font-size:12px;position:absolute;top:14px;">Парикмахерская в Горняке</a>
                    <iframe class="contacts__iframe" src="https://yandex.ru/map-widget/v1/-/CCURQEVs-B" width="80%"
                            height="400" frameborder="1" allowfullscreen="true" style="position:relative;">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?
echo vueTag('vue-application', ['services' => $services]);

$results = $mysql->query("SELECT * FROM review ORDER BY id DESC");
for ($i = 0; $i < 3; $i++) {
    $review = $results->fetch_assoc();
    $reviews[] = [
        'id' => $review['id'],
        'name' => limitSymbol($review['name'], 64),
        'message' => limitSymbol($review['review'], 255)
    ];
}

echo vueTag('vue-popup-review', ['initReviews' => $reviews]);

require_once 'php/footer.php' ?>
