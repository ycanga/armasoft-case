<h1>Proje kurulumu</h1>
<p>
    <ul>
        <li>
            Proje dosyaları içerisinde yer alan <b>run_project.sh</b> isimli dosyayı çalıştırarak tüm projenin otomatik ayağa kalkmasını sağlayabilirsiniz. (Kurulum sırasında bilgisayar parolası istenebilir.)
        </li>
        <li>
            Manuel olarak çalıştırmak için sırasıyla aşağıdaki komutları çalıştırmanız yeterli olacaktır.
            <ul>
                <li>
                    composer update
                </li>
                <li>
                    php artisan migrate --force
                </li>
                <li>
                    php artisan migrate:fresh --force
                </li>
                <li>
                    php artisan app:fetch-data
                </li>
                <li>
                    sudo npm i
                </li>
                <li>
                    npm run build
                </li>
                <li>
                    php artisan serve
                </li>
            </ul>
        </li>
    </ul>
</p>
