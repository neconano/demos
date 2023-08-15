import com.arkivanov.gradle.bundle
import com.arkivanov.gradle.setupMultiplatform
import com.arkivanov.gradle.setupSourceSets

plugins {
    id("kotlin-multiplatform")
    id("com.android.library")
    id("com.arkivanov.gradle.setup")
}

repositories {
    maven("https://oss.sonatype.org/content/groups/staging/") {
        credentials {
            username = "arkivanov"
            password = System.getenv("SONATYPE_PASSWORD")
        }
    }
}

setupMultiplatform()

val version = deps.versions.decompose.get()

android {
    namespace = "com.arkivanov.decompose.tools.checkpublication"
}

kotlin {
    setupSourceSets {
        val android by bundle()
        val jvm by bundle()

        common.main.dependencies {
            implementation("com.arkivanov.decompose:decompose:$version")
        }

        android.main.dependencies {
            implementation("com.arkivanov.decompose:extensions-android:$version")
            implementation("com.arkivanov.decompose:extensions-compose-jetbrains:$version")
            implementation("com.arkivanov.decompose:extensions-compose-jetpack:$version")
        }

        jvm.main.dependencies {
            implementation("com.arkivanov.decompose:extensions-compose-jetbrains:$version")
        }
    }
}
