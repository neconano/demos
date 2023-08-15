package com.smarttoolfactory.tutorial1_1basics.chapter4_state

import android.widget.Toast
import androidx.compose.foundation.Image
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.lazy.LazyListState
import androidx.compose.foundation.lazy.LazyRow
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.lazy.rememberLazyListState
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.Button
import androidx.compose.material.CircularProgressIndicator
import androidx.compose.material.FloatingActionButton
import androidx.compose.material.Icon
import androidx.compose.material.IconButton
import androidx.compose.material.OutlinedButton
import androidx.compose.material.Text
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Add
import androidx.compose.material.icons.filled.ArrowBack
import androidx.compose.material.icons.filled.Error
import androidx.compose.material.icons.filled.Remove
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.SideEffect
import androidx.compose.runtime.State
import androidx.compose.runtime.derivedStateOf
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.produceState
import androidx.compose.runtime.remember
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.runtime.setValue
import androidx.compose.runtime.snapshotFlow
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import com.smarttoolfactory.tutorial1_1basics.R
import com.smarttoolfactory.tutorial1_1basics.model.Place
import com.smarttoolfactory.tutorial1_1basics.model.places
import com.smarttoolfactory.tutorial1_1basics.ui.Blue400
import com.smarttoolfactory.tutorial1_1basics.ui.Orange400
import com.smarttoolfactory.tutorial1_1basics.ui.components.PlacesToBookComponent
import com.smarttoolfactory.tutorial1_1basics.ui.components.StyleableTutorialText
import com.smarttoolfactory.tutorial1_1basics.ui.components.TutorialText2
import kotlinx.coroutines.delay
import kotlinx.coroutines.flow.distinctUntilChanged
import kotlinx.coroutines.flow.filter
import kotlinx.coroutines.flow.map
import kotlinx.coroutines.launch
import kotlin.random.Random

@Preview
@Composable
fun Tutorial4_5_2Screen() {
    TutorialContent()
}

@Composable
private fun TutorialContent() {

    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
    ) {

        StyleableTutorialText(
            text = "1-) **SideEffect** function is triggered every time a recomposition occurs"
        )
        SideEffectExample()

        StyleableTutorialText(
            text = "2-) **produceState** launches a coroutine scoped to the Composition that " +
                    "can push values into a returned State."
        )
        ProduceStateSampleButton()

        val lazyListState: LazyListState = rememberLazyListState()
        StyleableTutorialText(
            text = "3-) Use **derivedStateOf** when a certain state is calculated " +
                    "or derived from other state objects."
        )

        TutorialText2(text = "derivedStateOf with Int")
        DerivedStateOfExample()
        TutorialText2(text = "derivedStateOf with LazyListState")
        DerivedStateOfSample2(lazyListState)

        StyleableTutorialText(
            text = "4-) Use **snapshotFlow** to convert **State<T>** objects into a **cold Flow**. " +
                    "snapshotFlow runs its block when collected and emits the result of the " +
                    "State objects read in it."
        )
        SnapshotFlowExample(lazyListState)
    }
}

/**
 * SideEffect function is triggered every time a recomposition occurs.
 *
 * SideEffect can be used to apply side effects to objects managed by the composition
 * that are not backed by snapshots so as not to leave those objects
 * in an inconsistent state if the current composition operation fails.
 */
@Composable
private fun SideEffectExample() {

    val context = LocalContext.current

    // Updates composable that listens changes in value of this State
    var counterOuter by remember { mutableStateOf(0) }
    // Updates composable that listens changes in value of this State
    var counterInner by remember { mutableStateOf(0) }

    // only runs first time SideEffectSample is called
    SideEffect {
        Toast.makeText(context, "SideEffectExample()", Toast.LENGTH_SHORT).show()
    }
    Column(
        Modifier
            .background(Orange400)
            .padding(8.dp)
    ) {

        // only runs first time SideEffectSample is called
        SideEffect {
            Toast.makeText(
                context,
                "SideEffectExample() OUTER",
                Toast.LENGTH_SHORT
            ).show()
        }

        Button(onClick = { counterOuter++ }, modifier = Modifier.fillMaxWidth()) {
            SideEffect {
                Toast.makeText(
                    context,
                    "SideEffectExample() Button OUTER",
                    Toast.LENGTH_SHORT
                )
                    .show()
            }
            Text(text = "Outer Composable: $counterOuter")
        }
        Column(
            Modifier
                .fillMaxWidth()
                .background(Blue400)
                .padding(8.dp)
        ) {

            SideEffect {
                Toast.makeText(
                    context,
                    "SideEffectExample() INNER",
                    Toast.LENGTH_SHORT
                )
                    .show()
            }

            Button(onClick = { counterInner++ }, modifier = Modifier.fillMaxWidth()) {

                SideEffect {
                    Toast.makeText(
                        context,
                        "SideEffectExample() Button INNER",
                        Toast.LENGTH_SHORT
                    )
                        .show()
                }
                Text(text = "Inner Composable: $counterInner")
            }

        }
    }
}


@Composable
private fun ProduceStateSampleButton() {

    var loadImage by remember {
        mutableStateOf(false)
    }

    Column(
        modifier = Modifier.fillMaxWidth(),
        horizontalAlignment = Alignment.CenterHorizontally
    ) {
        // Display a load image button when image is not loading
        OutlinedButton(
            onClick = {
                loadImage = !loadImage
            }
        ) {
            Text(text = "Click to load image with produceState $loadImage")
        }

        if (loadImage) {
            ProduceStateExample()
        }
    }
}

/**
 * produceState launches a coroutine scoped to the Composition that can push values into
 * a returned State. Use it to convert non-Compose state into Compose state,
 * for example bringing external subscription-driven
 * state such as Flow, LiveData, or RxJava into the Composition.
 *
 * The producer is launched when produceState enters the Composition,
 * and will be cancelled when it leaves the Composition. The returned State conflates;
 * setting the same value won't trigger a recomposition.
 * Even though produceState creates a coroutine, it can also be used to observe
 * non-suspending sources of data. To remove the subscription to that source,
 * use the awaitDispose function.
 */
@Composable
private fun ProduceStateExample() {
    val context = LocalContext.current

    val url = "www.example.com"
    val imageRepository = remember { ImageRepository() }

    val imageState = loadNetworkImage(url = url, imageRepository)

    when (imageState.value) {
        is Result.Loading -> {
            println("🔥 ProduceStateExample() Result.Loading")
            Toast.makeText(context, "🔥 ProduceStateExample() Result.Loading", Toast.LENGTH_SHORT)
                .show()
            CircularProgressIndicator()
        }

        is Result.Error -> {
            println("❌ ProduceStateExample() Result.Error")
            Toast.makeText(context, "❌ ProduceStateExample() Result.Error", Toast.LENGTH_SHORT)
                .show()

            Image(imageVector = Icons.Default.Error, contentDescription = null)
        }

        is Result.Success -> {
            println("✅ ProduceStateExample() Result.Success")
            Toast.makeText(context, "✅ ProduceStateExample() Result.Success", Toast.LENGTH_SHORT)
                .show()

            val image = (imageState!!.value as Result.Success).image

            Image(
                painterResource(id = image.imageIdRes),
                contentDescription = null
            )
        }
    }
}

@Composable
private fun loadNetworkImage(
    url: String,
    imageRepository: ImageRepository
): State<Result> {

    // Creates a State<T> with Result.Loading as initial value
    // If either `url` or `imageRepository` changes, the running producer
    // will cancel and will be re-launched with the new inputs.
    return produceState<Result>(initialValue = Result.Loading, url, imageRepository) {

        // In a coroutine, can make suspend calls
        val image = imageRepository.load(url)

        // Update State with either an Error or Success result.
        // This will trigger a recomposition where this State is read
        value = if (image == null) {
            Result.Error
        } else {
            Result.Success(image)
        }
    }
}

sealed class Result {
    object Loading : Result()
    object Error : Result()
    class Success(val image: ImageRes) : Result()
}

class ImageRes(val imageIdRes: Int)

class ImageRepository() {

    /**
     * Returns a drawable resource or null to simulate Result with Success or Error states
     */
    suspend fun load(url: String): ImageRes? {
        delay(2000)

        // Random is added to return null if get a random number that is zero.
        // Possibility of getting null is 1/4
        return if (Random.nextInt(until = 4) > 0) {

            val images = listOf(
                R.drawable.avatar_1_raster,
                R.drawable.avatar_2_raster,
                R.drawable.avatar_3_raster,
                R.drawable.avatar_4_raster,
                R.drawable.avatar_5_raster,
                R.drawable.avatar_6_raster,
            )

            // Load a random id each time load function is called
            ImageRes(images[Random.nextInt(images.size)])
        } else {
            null
        }
    }
}

@Composable
private fun DerivedStateOfExample() {

    var numberOfItems by remember {
        mutableStateOf(0)
    }

    // Use derivedStateOf when a certain state is calculated or derived from other state objects.
    // Using this function guarantees that the calculation will only occur whenever one
    // of the states used in the calculation changes.
    val derivedStateMax by remember {
        derivedStateOf {
            numberOfItems > 5
        }
    }
    val derivedStateMin by remember {
        derivedStateOf {
            numberOfItems > 0
        }
    }

    Column(modifier = Modifier.padding(horizontal = 8.dp)) {

        Row(verticalAlignment = Alignment.CenterVertically) {
            Text(text = "Amount to buy: $numberOfItems", modifier = Modifier.weight(1f))
            IconButton(onClick = { numberOfItems++ }) {
                Icon(imageVector = Icons.Default.Add, contentDescription = "add")
            }
            Spacer(modifier = Modifier.width(4.dp))
            IconButton(onClick = { if (derivedStateMin) numberOfItems-- }) {
                Icon(imageVector = Icons.Default.Remove, contentDescription = "remove")
            }
        }

        println(
            "🤔 COMPOSING..." +
                    "numberOfItems: $numberOfItems, " +
                    "derivedStateMax: $derivedStateMax, " +
                    "derivedStateMin: $derivedStateMin"
        )
        if (derivedStateMax) {
            Text("You cannot buy more than 5 items", color = Color(0xffE53935))
        }
    }
}

@Composable
private fun DerivedStateOfSample2(scrollState: LazyListState) {

    val coroutineScope = rememberCoroutineScope()

    val firstItemVisible by remember {
        derivedStateOf { scrollState.firstVisibleItemIndex != 0 }
    }

    Box {
        LazyRow(
            state = scrollState,
            horizontalArrangement = Arrangement.spacedBy(8.dp),
            content = {
                items(places) { place: Place ->
                    PlacesToBookComponent(place = place)
                }
            }
        )

        if (firstItemVisible) {
            FloatingActionButton(
                onClick = {
                    coroutineScope.launch {
                        scrollState.animateScrollToItem(0)
                    }
                },
                modifier = Modifier.align(Alignment.BottomEnd),
                backgroundColor = Color(0xffE53935)
            ) {
                Icon(
                    imageVector = Icons.Filled.ArrowBack,
                    contentDescription = null,
                    tint = Color.White
                )
            }
        }
    }
}

@Composable
private fun SnapshotFlowExample(scrollState: LazyListState) {

    var sentLogCount by remember { mutableStateOf(0) }

    LaunchedEffect(scrollState) {
        snapshotFlow { scrollState.firstVisibleItemIndex }
            .map { index -> index > 0 }
            .distinctUntilChanged()
            .filter { it }
            .collect {
                sentLogCount++
            }
    }

    if (sentLogCount > 0) {
        StyleableTutorialText(
            text = "💗 SnapshotFlowSample collect called **$sentLogCount** times " +
                    "after firstVisibleItemIndex > map threshold",
            bullets = false
        )
    }
}