#!/bin/bash

# Composer update
echo "Composer güncelleniyor..."
composer update
if [ $? -eq 0 ]; then
    echo "Composer güncelleme işlemi başarıyla tamamlandı."
else
    echo "Composer güncelleme işlemi sırasında bir hata oluştu."
    exit 1
fi

# Migration işlemi
echo "Veritabanı tabloları oluşturuluyor..."
php artisan migrate --force
if [ $? -eq 0 ]; then
    php artisan migrate:fresh --force
    echo "Veritabanı tabloları başarıyla oluşturuldu."
else
    echo "Veritabanı tabloları oluşturma işlemi sırasında bir hata oluştu."
    exit 1
fi

# Özel komut çalıştırma
echo "Uygulama verileri çekiliyor..."
php artisan app:fetch-data
if [ $? -eq 0 ]; then
    echo "Veri çekme işlemi başarıyla tamamlandı."
else
    echo "Veri çekme işlemi sırasında bir hata oluştu."
    exit 1
fi

# npm paketlerinin yüklenmesi
echo "NPM paketleri yükleniyor..."
sudo npm i
if [ $? -eq 0 ]; then
    echo "NPM paketleri başarıyla yüklendi."
else
    echo "NPM paketleri yükleme işlemi sırasında bir hata oluştu."
    exit 1
fi

# Uygulamanın derlenmesi
echo "Uygulama derleniyor..."
npm run build
if [ $? -eq 0 ]; then
    echo "Uygulama başarıyla derlendi."
else
    echo "Uygulama derleme işlemi sırasında bir hata oluştu."
    exit 1
fi

# Laravel sunucusunun başlatılması
echo "Laravel sunucusu başlatılıyor..."
php artisan serve
if [ $? -eq 0 ]; then
    echo "Laravel sunucusu başarıyla başlatıldı."
else
    echo "Laravel sunucusu başlatma işlemi sırasında bir hata oluştu."
    exit 1
fi
