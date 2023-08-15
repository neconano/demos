package com.jetpack.compose.learning.constraintlayout

import android.content.Intent
import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxHeight
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.requiredHeight
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.Card
import androidx.compose.material.ExperimentalMaterialApi
import androidx.compose.material.Icon
import androidx.compose.material.IconButton
import androidx.compose.material.MaterialTheme
import androidx.compose.material.Text
import androidx.compose.material.TopAppBar
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ArrowBack
import androidx.compose.material.icons.filled.KeyboardArrowRight
import androidx.compose.runtime.Composable
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.jetpack.compose.learning.theme.AppThemeState
import com.jetpack.compose.learning.theme.BaseView
import com.jetpack.compose.learning.theme.SystemUiController

class ConstraintLayoutActivity : ComponentActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContent {
            val systemUiController = remember { SystemUiController(window) }
            val appTheme = remember { mutableStateOf(AppThemeState()) }
            BaseView(appTheme.value, systemUiController) {
                ConstraintLayoutComponents()
            }
        }
    }

    @Preview
    @Composable
    fun ConstraintLayoutComponents() {
        val spaceHeight = 24.dp
        Column(Modifier.background(MaterialTheme.colors.background).fillMaxHeight()) {
            TopAppBar(
                title = { Text("Constraint Layout") },
                navigationIcon = {
                    IconButton(onClick = { onBackPressed() }) {
                        Icon(Icons.Filled.ArrowBack, contentDescription = null)
                    }
                }
            )
            Column(Modifier.padding(20.dp)) {
                ConstraintLayoutItems(
                    type = "Barrier",
                    intent = Intent(applicationContext, BarrierActivity::class.java)
                )
                Spacer(Modifier.requiredHeight(spaceHeight))
                ConstraintLayoutItems(
                    type = "Guideline",
                    intent = Intent(applicationContext, GuidelineActivity::class.java)
                )
                Spacer(Modifier.requiredHeight(spaceHeight))
                ConstraintLayoutItems(
                    type = "Chain",
                    intent = Intent(applicationContext, ChainActivity::class.java)
                )
            }
        }
    }

    @Composable
    @OptIn(ExperimentalMaterialApi::class)
    fun ConstraintLayoutItems(type: String, intent: Intent) {
        val context = LocalContext.current
        Card(
            modifier = Modifier.fillMaxWidth(),
            shape = RoundedCornerShape(10.dp),
            border = BorderStroke(1.dp, Color.LightGray),
            elevation = 5.dp,
            onClick = {
                context.startActivity(intent)
            }
        ) {
            Row(
                Modifier
                    .fillMaxWidth()
                    .height(50.dp)
                    .padding(10.dp),
                verticalAlignment = Alignment.CenterVertically,
            ) {
                Text(type, Modifier.weight(1f), fontSize = 16.sp)
                Icon(Icons.Default.KeyboardArrowRight, "", Modifier.size(24.dp))
            }
        }
    }
}