package com.ellison.flappybird.view

import androidx.compose.foundation.Image
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.tooling.preview.Preview
import com.ellison.flappybird.util.LogUtil
import com.ellison.flappybird.R

@Preview(widthDp = 411, heightDp = 660)
@Composable
fun previewBackground() {
    FarBackground(Modifier.fillMaxSize())
}
@Composable
fun FarBackground(modifier: Modifier) {
    Column {
        Image(
            painter = painterResource(id = R.drawable.background),
            contentScale = ContentScale.FillBounds,
            contentDescription = null,
            modifier = modifier.fillMaxSize()
        )
    }
}
