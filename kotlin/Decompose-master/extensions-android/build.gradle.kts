import com.arkivanov.gradle.setupAndroidLibrary
import com.arkivanov.gradle.setupBinaryCompatibilityValidator
import com.arkivanov.gradle.setupPublication

plugins {
    id("com.android.library")
    id("kotlin-android")
    id("com.arkivanov.gradle.setup")
}

setupAndroidLibrary()
setupPublication()
setupBinaryCompatibilityValidator()

android {
    namespace = "com.arkivanov.decompose.extensions.android"
}

dependencies {
    implementation(project(":decompose"))
}
