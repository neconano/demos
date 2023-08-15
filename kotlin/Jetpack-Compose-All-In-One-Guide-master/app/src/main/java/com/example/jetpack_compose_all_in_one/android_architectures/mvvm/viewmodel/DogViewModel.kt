package com.example.jetpack_compose_all_in_one.android_architectures.mvvm.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.jetpack_compose_all_in_one.android_architectures.mvvm.model.DogRepository
import com.example.jetpack_compose_all_in_one.android_architectures.mvvm.model.data.DogResponse
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class DogViewModel @Inject constructor(private val repository: DogRepository) : ViewModel() {

    private val dogLiveData = MutableLiveData<DogResponse>()
    private val error = MutableLiveData<String>()

    var dogFluff by mutableStateOf(DogResponse.empty)

    fun getDogImageFromApi() {
        viewModelScope.launch(Dispatchers.IO) {
            try {
                val response = repository.getDogImage()
                if (response.isSuccessful) {
                    response.body()?.let {
                        dogLiveData.postValue(it)
                        dogFluff = it
                    }
                } else {
                    error.postValue("Failed to load data!")
                }
            } catch (e: Exception) {
                error.postValue(e.toString())
                e.printStackTrace()
            }
        }
    }
}