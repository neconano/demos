import Lib.Android.ACCOMPANIST_SYSTEM_UI_CONTROLLER

plugins {
    id(BuildPlugins.ANDROID_APPLICATION_PLUGIN)
    id(BuildPlugins.KOTLIN_ANDROID_PLUGIN)
    id(BuildPlugins.KOTLIN_PARCELABLE_PLUGIN)
    id(BuildPlugins.KOTLIN_KAPT)
    id(BuildPlugins.DAGGER_HILT)
}

android {
    compileSdk = ProjectProperties.COMPILE_SDK

    defaultConfig {
        applicationId = ProjectProperties.APPLICATION_ID
        minSdk = ProjectProperties.MIN_SDK
        targetSdk = ProjectProperties.TARGET_SDK
        versionCode = 1
        versionName = "1.0"
        testInstrumentationRunner = "androidx.test.runner.AndroidJUnitRunner"
        vectorDrawables.useSupportLibrary = true
    }

    buildTypes {
        getByName("release") {
            isDebuggable = true
            isMinifyEnabled = false
            proguardFiles(
                getDefaultProguardFile("proguard-android.txt"),
                "proguard-common.txt",
                "proguard-specific.txt"
            )
        }
    }

    buildFeatures {
        dataBinding = true
    }

    buildFeatures {
        compose = true
    }

    composeOptions {
        kotlinCompilerExtensionVersion = Lib.Android.COMPOSE_COMPILER_VERSION
    }
    packagingOptions {
        resources.excludes.add("META-INF/LICENSE.txt")
        resources.excludes.add("META-INF/NOTICE.txt")
        resources.excludes.add("LICENSE.txt")
        resources.excludes.add("/META-INF/{AL2.0,LGPL2.1}")
    }

    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_1_8
        targetCompatibility = JavaVersion.VERSION_1_8
    }

    kotlinOptions {
        jvmTarget = "1.8"
    }
}

// Required for annotation processing plugins like Dagger
kapt {
    generateStubs = true
    correctErrorTypes = true
}

dependencies {
    implementation(platform(Lib.Android.COMPOSE_BOM))
    implementation(project(":feature:dashboard"))
    implementation(project(":feature:card"))
    implementation(project(":feature:taskboard"))
    implementation(project(":feature:search"))

    implementation(project(":core:data"))
    implementation(project(":core:domain"))
    implementation(project(":core:designsystem"))
    implementation(project(":core:navigation"))

    implementation("androidx.tracing:tracing-ktx:1.1.0")
    implementation("androidx.compose.material3:material3")
    implementation("androidx.compose.material3:material3-window-size-class")

    /* Android Designing and layout */
    implementation(Lib.Android.COMPOSE_LIVEDATA)
    implementation(Lib.Android.COMPOSE_NAVIGATION)
    implementation(Lib.Kotlin.KT_STD)
    implementation(Lib.Android.MATERIAL_DESIGN)
    implementation(Lib.Android.CONSTRAINT_LAYOUT_COMPOSE)
    implementation(Lib.Android.ACCOMPANIST_INSETS)
    implementation(Lib.Android.ACCOMPANIST_INSETS_UI)
    implementation(ACCOMPANIST_SYSTEM_UI_CONTROLLER)
    implementation(Lib.Android.ACCOMPANIST_FLOW_LAYOUTS)
    implementation(Lib.Android.COMPOSE_WINDOW_MATRICES)

    implementation(Lib.Android.APP_COMPAT)

    implementation(Lib.Kotlin.KTX_CORE)

    /* Image Loading */
    implementation(Lib.Android.COIL_COMPOSE)
    implementation(Lib.Android.ACCOMPANIST_COIL)

    /*DI*/
    implementation(Lib.Di.hiltAndroid)
    implementation(Lib.Di.hiltNavigationCompose)
    implementation(Lib.Android.COMPOSE_TOOLING_PREVIEW)
    debugImplementation(Lib.Android.COMPOSE_TOOLING)

    implementation(Lib.Android.PROFILE_INSTALLER)

    kapt(Lib.Di.hiltCompiler)
    kapt(Lib.Di.hiltAndroidCompiler)

    /* Logger */
    implementation(Lib.Logger.TIMBER)

    /* Async */
    implementation(Lib.Async.COROUTINES)
    implementation(Lib.Async.COROUTINES_ANDROID)

    /* Glance AppWidgets */
    implementation(Lib.Glance.GLANCE)

    /* Room */
    implementation(Lib.Room.roomRuntime)
    kapt(Lib.Room.roomCompiler)
    implementation(Lib.Room.roomKtx)
    implementation(Lib.Room.roomPaging)

    /* Datastore */
    implementation(Lib.Android.JETPACK_DATASTORE)
    implementation(Lib.Android.JETPACK_DATASTORE_PREFERENCE_CORE)

    /*Testing*/
    testImplementation(TestLib.JUNIT)
    testImplementation(TestLib.CORE_TEST)
    testImplementation(TestLib.ANDROID_JUNIT)
    testImplementation(TestLib.ARCH_CORE)
    testImplementation(TestLib.MOCK_WEB_SERVER)
    testImplementation(TestLib.ROBO_ELECTRIC)
    testImplementation(TestLib.COROUTINES)
    testImplementation(TestLib.MOCKK)
    androidTestImplementation(Lib.Android.COMPOSE_JUNIT)
    debugImplementation(Lib.Android.COMPOSE_TEST_MANIFEST)
}
ktlint {
    android.set(true)
    outputColorName.set("RED")
}
