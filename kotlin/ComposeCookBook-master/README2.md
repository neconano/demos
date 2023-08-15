###


## 语法
### lambda 表达式作为参数
```kotlin
    fun BaseView(
        appThemeState: AppThemeState,
        systemUiController: SystemUiController?,
        content: @Composable () -> Unit
    )
    // 需要注意的是第三个参数 content 的传递方式
    BaseView(appTheme.value, systemUiController) {
        MainAppContent(appTheme)
    }
```
该方法的思想，跳过前面的参数，直接传最后一个，content 一般为自定义内容
fun A(a,b,...,content: @Composable () -> Unit){
    ...
}



