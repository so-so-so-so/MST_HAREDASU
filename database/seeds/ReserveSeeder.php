<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReserveSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //
    DB::table('users')->insert([
      'name' => 'テス山テス太郎',
      'name_kana' => 'テスヤマテスタロウ',
      'email' => 'test000@gmail.com',
      'password' => '$2y$10$eUuc5/3uHYjXct/Gif/laO2sC9vjy6RU0BpH8vtmQK9kOu22TN31W',
      'tell' => '00000000000',
      'zip' => '0000000',
      'address' => 'テスト県テスト区テスト',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.694055',
      'longitude' => '139.700753',
      'address' => 'エスパス日拓西武新宿駅前店',
      'date' => '2022-01-05',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.691605',
      'longitude' => '139.696946',
      'address' => 'コクーンタワー',
      'date' => '2022-01-05',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.689807',
      'longitude' => '139.692115',
      'address' => '東京都庁',
      'date' => '2022-01-06',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.689779',
      'longitude' => '139.700355',
      'address' => '新宿駅',
      'date' => '2022-01-06',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.694055',
      'longitude' => '139.700753',
      'address' => 'エスパス日拓西武新宿駅前店',
      'date' => '2022-01-07',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.691605',
      'longitude' => '139.696946',
      'address' => 'コクーンタワー',
      'date' => '2022-01-07',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.689807',
      'longitude' => '139.692115',
      'address' => '東京都庁',
      'date' => '2022-01-08',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.689779',
      'longitude' => '139.700355',
      'address' => '新宿駅',
      'date' => '2022-01-08',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.694055',
      'longitude' => '139.700753',
      'address' => 'エスパス日拓西武新宿駅前店',
      'date' => '2022-01-09',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.691605',
      'longitude' => '139.696946',
      'address' => 'コクーンタワー',
      'date' => '2022-01-09',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.689807',
      'longitude' => '139.692115',
      'address' => '東京都庁',
      'date' => '2022-01-13',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
    DB::table('reserves')->insert([
      'user_id' => '1',
      'latitude' => '35.689779',
      'longitude' => '139.700355',
      'address' => '新宿駅',
      'date' => '2022-01-13',
      'start_time' => '18:00',
      'end_time' => '21:00',
      'area' => '300',
      'drone' => '200',
      'cost' => '300000',
      'status' => '0',
    ]);
  }
}
