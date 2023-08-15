package com.smarttoolfactory.tutorial1_1basics.chapter4_state

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.material.Button
import androidx.compose.material.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import com.smarttoolfactory.tutorial1_1basics.ui.Blue400
import com.smarttoolfactory.tutorial1_1basics.ui.Green400
import com.smarttoolfactory.tutorial1_1basics.ui.Orange400
import com.smarttoolfactory.tutorial1_1basics.ui.Pink400
import com.smarttoolfactory.tutorial1_1basics.ui.components.StyleableTutorialText

@Preview
@Composable
fun Tutorial4_1Screen1() {
    TutorialContent()
}

@Composable
private fun TutorialContent() {
    Column(modifier = Modifier.fillMaxSize()) {

        StyleableTutorialText(
            text = "Remember stores the initial calculation from composition. This value survives " +
                    "recomposition which acts as cache for functions.",
            bullets = false
        )

        StyleableTutorialText(
            text = "At outer level there is no **recomposition** since " +
                    "mutableState(counter) is not read by outer level. " +
                    "Because of that **only in this counter myVal gets updated**.",
            bullets = false
        )
        Counter1()
        Spacer(modifier = Modifier.height(8.dp))
        StyleableTutorialText(
            text = "In counter 2 and 3 **myVal is always 0** because " +
                    "its initial value is remembered in outer composable",
            bullets = false
        )
        Counter2()
        Spacer(modifier = Modifier.height(8.dp))
        Counter3()
        Spacer(modifier = Modifier.height(8.dp))
        StyleableTutorialText(
            text = "Since **MyData** is remembered in every recomposition initial one in " +
                    "**remember** is retained. Because of this it's initial value is " +
                    "displayed in inner composition",
            bullets = false
        )
        Counter4()
    }
}

@Composable
private fun Counter1() {

    Column(
        modifier = Modifier
            .background(Orange400)
            .fillMaxWidth()
            .padding(4.dp)
    ) {
        var counter by remember { mutableStateOf(0) }
        val myData = remember { MyData() }
        var myVal = 0

        Text("myVal: $myVal, myData value: ${myData.value}")

        Button(
            modifier = Modifier
                .fillMaxWidth()
                .padding(vertical = 4.dp),
            onClick = {
                counter++
                // 🔥 MyVal gets updated only here because outer composable is not recomposed
                // because Text above button does not listen for changes in mutableStateOf counter
                myVal++
                // Since no composition above my data object does not change even without remember
                myData.value = myData.value + 1
            }) {
            Text("Counter: $counter, myVal: $myVal, myData value: ${myData.value}")
        }
    }
}

@Composable
private fun Counter2() {

    Column(
        modifier = Modifier
            .background(Blue400)
            .fillMaxWidth()
            .padding(4.dp)
    ) {
        var counter by remember { mutableStateOf(0) }
        val myData = remember { MyData() }
        var myVal = remember { 0 }

        Text("Counter: $counter, myVal: $myVal, myData value: ${myData.value}")

        Button(
            modifier = Modifier
                .fillMaxWidth()
                .padding(vertical = 4.dp),
            onClick = {
                counter++
                // 🎃 MyVal doesn't change because we always remember 0 on each recomposition
                myVal++
                myData.value = myData.value + 1
            }) {
            Text("myVal: $myVal, myData value: ${myData.value}")
        }
    }
}

@Composable
private fun Counter3() {

    Column(
        modifier = Modifier
            .background(Pink400)
            .fillMaxWidth()
            .padding(4.dp)
    ) {

        var counter by remember { mutableStateOf(0) }
        val myData = remember { MyData() }
        var myVal = 0

        Text("Counter: $counter, myVal: $myVal, myData value: ${myData.value}")

        Button(
            modifier = Modifier
                .fillMaxWidth()
                .padding(vertical = 4.dp),
            onClick = {
                counter++
                myVal++
                myData.value = myData.value + 1
            }) {
            Text("Counter: $counter, myVal: $myVal, myData value: ${myData.value}")
        }
    }
}

@Composable
private fun Counter4() {

    Column(
        modifier = Modifier
            .background(Green400)
            .fillMaxWidth()
            .padding(4.dp)
    ) {

        var counter by remember { mutableStateOf(0) }
        var myData = remember { MyData() }
        var myVal = remember { 0 }

        Text("Counter: $counter, myVal: $myVal, myData value: ${myData.value}")

        Button(
            modifier = Modifier
                .fillMaxWidth()
                .padding(vertical = 4.dp),
            onClick = {
                counter++
                myVal++
                // 🔥 Since MyData is remembered on each composition the one initially instantiated
                // inside remember is retained
                myData = MyData(myData.value + 1)
            }) {
            Text("Counter: $counter, myVal: $myVal, myData value: ${myData.value}")
        }
    }
}

class MyData(var value: Int = 0)
