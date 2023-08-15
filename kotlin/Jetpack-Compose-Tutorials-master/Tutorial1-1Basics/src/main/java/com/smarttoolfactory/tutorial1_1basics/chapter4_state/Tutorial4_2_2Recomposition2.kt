package com.smarttoolfactory.tutorial1_1basics.chapter4_state

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.CutCornerShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.Button
import androidx.compose.material.ButtonDefaults
import androidx.compose.material.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.shadow
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import com.smarttoolfactory.tutorial1_1basics.ui.components.StyleableTutorialText
import com.smarttoolfactory.tutorial1_1basics.ui.components.getRandomColor

@Preview
@Composable
fun Tutorial4_2_2Screen() {
    TutorialContent()
}

@Composable
private fun TutorialContent() {

    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
            .padding(8.dp)
    ) {

        StyleableTutorialText(
            text = "Only text at the bottom is recomposed when we update **mutableState** " +
                    "because **Text** on top doesn't read state.",
            bullets = false
        )
        Sample1()
        StyleableTutorialText(
            text = "Only **Text**s are updated when the mutableState(s) they read are changed.",
            bullets = false
        )
        Sample2()
        StyleableTutorialText(
            text = "**update1** mutableState causes whole Composable to be recomposed because " +
                    "it's read by **Text** with 🔥. Only **SomeComposable with no args** " +
                    "is not recomposed.",
            bullets = false
        )
        Sample3()
        StyleableTutorialText(
            text = "**update1** mutableState triggers whole Composable to be recomposed because " +
                    "it's observed by **Text** with 🔥. **SomeComposable** that takes " +
                    "**update2** as arg causing while composable to be recomposed. " +
                    "SomeComposable that has no args is not recomposed.",
            bullets = false
        )
        Sample4()
        StyleableTutorialText(
            text = "Only separate composables, **SomeComposable with no args**, that are not " +
                    "updated parent from Composable are not recomposed. Composables have params " +
                    "are updated when the params they have are changed.",
            bullets = false
        )
        Sample5()
    }
}

@Preview
@Composable
private fun Sample1() {
    Column(
        modifier = Modifier
            .padding(4.dp)
            .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
            .background(getRandomColor())
            .padding(4.dp)
    ) {
        var counter by remember { mutableStateOf(0) }

        Text("Sample1", color = getRandomColor())
        Button(
            modifier = Modifier.fillMaxWidth(),
            colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
            onClick = { counter++ },
            shape = RoundedCornerShape(5.dp)
        ) {
            Text("Counter: $counter", color = getRandomColor())
        }
    }
}

@Preview
@Composable
private fun Sample2() {
    Column(
        modifier = Modifier
            .padding(4.dp)
            .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
            .background(getRandomColor())
            .padding(4.dp)
    ) {
        var update1 by remember { mutableStateOf(0) }
        var update2 by remember { mutableStateOf(0) }

        println("ROOT")
        Text("Sample2", color = getRandomColor())

        Button(
            modifier = Modifier.fillMaxWidth(),
            colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
            onClick = { update1++ },
            shape = RoundedCornerShape(5.dp)
        ) {

            println("🔥 Button 1")

            Text(
                text = "Update1: $update1",
                textAlign = TextAlign.Center,
                color = getRandomColor()
            )
        }

        Button(
            modifier = Modifier.fillMaxWidth(),
            colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
            onClick = { update2++ },
            shape = RoundedCornerShape(5.dp)
        ) {

            println("🍏 Button 2")

            Text(
                text = "Update2: $update2",
                textAlign = TextAlign.Center,
                color = getRandomColor()
            )
        }

        Column(
            modifier = Modifier
                .padding(4.dp)
                .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
                .background(getRandomColor())
                .padding(4.dp)
        ) {

            println("🚀 Inner Column")
            var update3 by remember { mutableStateOf(0) }

            Button(
                modifier = Modifier.fillMaxWidth(),
                colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
                onClick = { update3++ },
                shape = RoundedCornerShape(5.dp)
            ) {

                println("✅ Button 3")
                Text(
                    text = "Update2: $update2, Update3: $update3",
                    textAlign = TextAlign.Center,
                    color = getRandomColor()
                )
            }

            Column(
                modifier = Modifier
                    .padding(4.dp)
                    .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
                    .background(getRandomColor())
                    .padding(4.dp)
            ) {

                println("☕️ Bottom Column")
                Text("Sample2", color = getRandomColor())
            }
        }
    }
}

@Preview
@Composable
private fun Sample3() {
    Column(
        modifier = Modifier
            .padding(4.dp)
            .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
            .background(getRandomColor())
            .padding(4.dp)
    ) {
        var update1 by remember { mutableStateOf(0) }
        var update2 by remember { mutableStateOf(0) }

        println("ROOT")
        Text("Sample3", color = getRandomColor())

        Button(
            modifier = Modifier.fillMaxWidth(),
            colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
            onClick = { update1++ },
            shape = RoundedCornerShape(5.dp)
        ) {

            println("🔥 Button 1")

            Text(
                text = "Update1: $update1",
                textAlign = TextAlign.Center,
                color = getRandomColor()
            )

        }

        Button(
            modifier = Modifier.fillMaxWidth(),
            colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
            onClick = { update2++ },
            shape = RoundedCornerShape(5.dp)
        ) {

            println("🍏 Button 2")

            Text(
                text = "Update2: $update2",
                textAlign = TextAlign.Center,
                color = getRandomColor()
            )
        }

        Column(
            modifier = Modifier
                .padding(4.dp)
                .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
                .background(getRandomColor())
                .padding(4.dp)
        ) {

            println("🚀 Inner Column")
            var update3 by remember { mutableStateOf(0) }

            Button(
                modifier = Modifier.fillMaxWidth(),
                colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
                onClick = { update3++ },
                shape = RoundedCornerShape(5.dp)
            ) {

                println("✅ Button 3")
                Text(
                    text = "Update2: $update2, Update3: $update3",
                    textAlign = TextAlign.Center,
                    color = getRandomColor()
                )
            }

            Column(
                modifier = Modifier
                    .padding(4.dp)
                    .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
                    .background(getRandomColor())
                    .padding(4.dp)
            ) {

                println("☕️ Bottom Column")
                /*
                    🔥🔥 Observing update(mutableState) causes entire composable to recompose
                 */
                Text(
                    text = "🔥 Update1: $update1",
                    textAlign = TextAlign.Center,
                    color = getRandomColor()
                )
            }
        }

        Text(
            text = "Sample3",
            textAlign = TextAlign.Center,
            color = getRandomColor()
        )
        // 🔥🔥 Since it's a separate function it's not recomposed
        // without updating it with an argument
        SomeComposable()
    }
}

@Preview
@Composable
private fun Sample4() {

    Column(
        modifier = Modifier
            .padding(4.dp)
            .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
            .background(getRandomColor())
            .padding(4.dp)
    ) {
        var update1 by remember { mutableStateOf(0) }
        var update2 by remember { mutableStateOf(0) }

        println("ROOT")
        Text("Sample4", color = getRandomColor())

        Button(
            modifier = Modifier.fillMaxWidth(),
            colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
            onClick = { update1++ },
            shape = RoundedCornerShape(5.dp)
        ) {

            println("🔥 Button 1")

            Text(
                text = "Update1: $update1",
                textAlign = TextAlign.Center,
                color = getRandomColor()
            )

        }

        Button(
            modifier = Modifier.fillMaxWidth(),
            colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
            onClick = { update2++ },
            shape = RoundedCornerShape(5.dp)
        ) {

            println("🍏 Button 2")

            Text(
                text = "Update2: $update2",
                textAlign = TextAlign.Center,
                color = getRandomColor()
            )
        }

        Column(
            modifier = Modifier
                .padding(4.dp)
                .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
                .background(getRandomColor())
                .padding(4.dp)
        ) {

            println("🚀 Inner Column")
            var update3 by remember { mutableStateOf(0) }

            Button(
                modifier = Modifier.fillMaxWidth(),
                colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
                onClick = { update3++ },
                shape = RoundedCornerShape(5.dp)
            ) {

                println("✅ Button 3")
                Text(
                    text = "Update2: $update2, Update3: $update3",
                    textAlign = TextAlign.Center,
                    color = getRandomColor()
                )
            }

            Column(
                modifier = Modifier
                    .padding(4.dp)
                    .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
                    .background(getRandomColor())
                    .padding(4.dp)
            ) {

                println("☕️ Bottom Column")
                /*
                    🔥🔥 Observing update(mutableState) causes entire composable to recompose
                 */
                Text(
                    text = "🔥Update1: $update1",
                    textAlign = TextAlign.Center,
                    color = getRandomColor()
                )
                // 🔥🔥 Since it's a separate function it's not recomposed
                // without updating it with an argument
                SomeComposable()
            }
        }

        // 🔥🔥 Since it's a separate function it's not recomposed
        // without updating it with an argument
        SomeComposable()
        // 🔥🔥 It's updated since we sent an argument to it
        SomeComposable(update2)
    }
}

@Preview
@Composable
private fun Sample5() {
    Column(
        modifier = Modifier
            .padding(4.dp)
            .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
            .background(getRandomColor())
            .padding(4.dp)
    ) {
        var update1 by remember { mutableStateOf(0) }
        var update2 by remember { mutableStateOf(0) }

        println("ROOT")
        Text("Sample5", color = getRandomColor())

        Button(
            modifier = Modifier.fillMaxWidth(),
            colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
            onClick = { update1++ },
            shape = RoundedCornerShape(5.dp)
        ) {
            println("🔥 Button 1")

            Text(
                text = "Update1: $update1",
                textAlign = TextAlign.Center,
                color = getRandomColor()
            )
        }

        Button(
            modifier = Modifier.fillMaxWidth(),
            colors = ButtonDefaults.buttonColors(backgroundColor = getRandomColor()),
            onClick = { update2++ },
            shape = RoundedCornerShape(5.dp)
        ) {
            println("🍏 Button 2")

            Text(
                text = "Update2: $update2",
                textAlign = TextAlign.Center,
                color = getRandomColor()
            )
        }

        Column(
            modifier = Modifier
                .padding(4.dp)
                .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
                .background(getRandomColor())
                .padding(4.dp)
        ) {

            println("🚀 Inner Column")

            Column(
                modifier = Modifier
                    .padding(4.dp)
                    .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
                    .background(getRandomColor())
                    .padding(4.dp)
            ) {

                println("☕️ Bottom Column")
                /*
                    🔥🔥 Observing update(mutableState) causes entire composable to recompose
                 */
                Text(
                    text = "Update1: $update1",
                    textAlign = TextAlign.Center,
                    color = getRandomColor()
                )
            }
            // 🔥🔥 Since it's a separate function it's not recomposed
            // without updating it with an argument
            SomeComposable()
            // 🔥🔥 It's updated since we sent an argument to it
            SomeComposable(update2)
        }

        // 🔥🔥 Since it's a separate function it's not recomposed
        // without updating it with an argument
        SomeComposable()
        // 🔥🔥 It's updated since we sent an argument to it
        AnotherComposable(update2)
    }
}

@Composable
private fun SomeComposable(update: Int = 0) {

    println("🚀 SomeComposable() Composable")

    val text = if(update == 0 ) "no args" else "update: $update"
    Text(
        modifier = Modifier.fillMaxWidth().background(getRandomColor()),
        text = "SomeComposable $text",
        textAlign = TextAlign.Center,
        color = getRandomColor()
    )
}


@Composable
private fun AnotherComposable(update: Int) {

    println(" AnotherComposable() First Column")

    val text = if(update == 0 ) "no args" else "update: $update"

    Column(
        modifier = Modifier
            .padding(4.dp)
            .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
            .background(getRandomColor())
            .padding(4.dp)
    ) {
        Text(
            modifier = Modifier.fillMaxWidth(),
            text = "AnotherComposable $text ",
            textAlign = TextAlign.Center,
            color = getRandomColor()
        )
        Column(
            modifier = Modifier
                .padding(4.dp)
                .shadow(1.dp, shape = CutCornerShape(topEnd = 8.dp))
                .background(getRandomColor())
                .padding(4.dp)
        ) {
            Text(
                modifier = Modifier.fillMaxWidth(),
                text = "AnotherComposable bottom inner text",
                textAlign = TextAlign.Center,
                color = getRandomColor()
            )
        }
    }
}