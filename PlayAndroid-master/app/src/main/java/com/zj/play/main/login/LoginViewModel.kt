package com.zj.play.main.login

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.zj.core.Play
import com.zj.core.util.showToast
import com.zj.model.model.Login
import com.zj.play.R
import com.zj.play.article.ArticleBroadCast
import com.zj.play.base.http
import dagger.hilt.android.lifecycle.HiltViewModel
import javax.inject.Inject

@HiltViewModel
class LoginViewModel @Inject constructor(
    application: Application,
    private val accountRepository: AccountRepository
) : AndroidViewModel(application) {

    private val _state = MutableLiveData<LoginState>()
    val state: LiveData<LoginState>
        get() = _state

    fun toLoginOrRegister(account: Account) {
        _state.postValue(Logining)
        if (account.isLogin) {
            login(account)
        } else {
            register(account)
        }
    }

    private fun login(account: Account) {
        viewModelScope.http(
            request = { accountRepository.getLogin(account.username, account.password) },
            response = { success(it, account.isLogin) },
            error = { _state.postValue(LoginError) }
        )
    }


    private fun register(account: Account) {
        viewModelScope.http(
            request = {
                accountRepository.getRegister(
                    account.username,
                    account.password,
                    account.password
                )
            },
            response = { success(it, account.isLogin) },
            error = { _state.postValue(LoginError) }
        )
    }

    private fun success(it: Login?, isLogin: Boolean) {
        it ?: return
        _state.postValue(LoginSuccess(it))
        Play.setLogin(true)
        Play.setUserInfo(it.nickname, it.username)
        ArticleBroadCast.sendArticleChangesReceiver(context = getApplication())
        // toast登录成功
        getApplication<Application>().showToast(
            if (isLogin) getApplication<Application>().getString(R.string.login_success) else getApplication<Application>().getString(
                R.string.register_success
            )
        )
    }

}

data class Account(val username: String, val password: String, val isLogin: Boolean)

/**
 * 定义不同类型用于返回UI显示
 * */
sealed class LoginState
object Logining : LoginState()
object LoginError : LoginState()
data class LoginSuccess(val login: Login) : LoginState()
