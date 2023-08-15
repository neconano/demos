package com.example.jetpack_compose_all_in_one.android_architectures.mvvm.model

import com.example.jetpack_compose_all_in_one.android_architectures.mvvm.model.data.DogResponse
import retrofit2.Response
import retrofit2.http.GET

interface DogApiService {

    @GET("woof.json")
    suspend fun getRandomDog():Response<DogResponse>
}