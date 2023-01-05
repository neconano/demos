package com.zj.play

import android.app.Application
import com.scwang.smart.refresh.footer.ClassicsFooter
import com.scwang.smart.refresh.header.ClassicsHeader
import com.scwang.smart.refresh.layout.SmartRefreshLayout
import com.tencent.bugly.crashreport.CrashReport
import com.zj.core.Play
import dagger.hilt.android.HiltAndroidApp
import kotlinx.coroutines.*

@HiltAndroidApp
class App : Application() {

    override fun onCreate() {
        super.onCreate()
        Play.initialize(applicationContext)
        initData()
    }

    /**
     * [参考阅读](https://blog.csdn.net/u011133887/article/details/98617852)
     * [参考阅读](https://www.bilibili.com/read/cv13360620)
     * ```
     * runBlocking 阻塞当前线程，运行 suspend 修饰的可挂起函数实现协程
     * CoroutineScope会跟踪它使用的 launch 和 async 创建的所有协程，等待所有子协程执行完毕后返回
     * launch 启动新的协程，默认立即执行
     * async 配合 await 会阻塞当前协程
     * yield 手动挂起当前协程，执行后续协程
     */
    private fun initData() {
        /**
         * 协程总是运行在一些以CoroutineContext类型为代表的上下文中
         *
         * 如下通过 + 的方式构建一个CoroutineContext
         *
         * SupervisorJob 不会因为子协程崩溃影响父协程
         */
        val coroutineContext = SupervisorJob() + Dispatchers.IO
        // val coroutineContext = SupervisorJob() + CoroutineName("name") + Dispatchers.IO
        CoroutineScope(coroutineContext).launch {
            initBugLy()
        }
    }

    // 崩溃上报 https://bugly.qq.com/
    private fun initBugLy() {
        CrashReport.initCrashReport(applicationContext, "31bc88743c", false)
        // CrashReport.testJavaCrash();
    }

    /**
     * object声明（一个类）是延迟加载的，只有当第一次被访问时才会初始化，所以被用来实现单例
     *
     * companion object是当包含它的类被加载时就初始化了的，所以伴生类初始化会先执行
     */
    companion object {
        init {
            //设置全局的Header构建器
            SmartRefreshLayout.setDefaultRefreshHeaderCreator { context, layout ->
                layout.setPrimaryColorsId(
                    R.color.refresh,
                    R.color.text_color
                )
                // 指定为经典Header，默认是 贝塞尔雷达Header
                ClassicsHeader(context)
            }
            SmartRefreshLayout.setDefaultRefreshFooterCreator { context, _ ->
                //指定为经典Footer，默认是 BallPulseFooter
                ClassicsFooter(context).setDrawableSize(20f)
            }
        }
    }
}
