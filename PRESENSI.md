untuk melakukan prosesing terhadap sinkronisasi presensi dapat memanggil bash script di sebuah cron job di setiap 5 menit.

script harus memiliki permission untuk di eksekusi
chmod a+x presensi

crontab -e

lalu tambahkan di bagian bawah crontab. script harus di eksekusi menggunakan absolute path
*/5 * * * * ./home/resc/siklis/presensi

# waktu cron job  ./script
*/5 * * * * ./presensi