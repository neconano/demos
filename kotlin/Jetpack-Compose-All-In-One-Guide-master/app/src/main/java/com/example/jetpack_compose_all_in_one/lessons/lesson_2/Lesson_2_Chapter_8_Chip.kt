package com.example.jetpack_compose_all_in_one.lessons.lesson_2

import android.widget.Toast
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.ExperimentalLayoutApi
import androidx.compose.foundation.layout.FlowRow
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.LazyRow
import androidx.compose.material.Chip
import androidx.compose.material.ChipDefaults
import androidx.compose.material.ExperimentalMaterialApi
import androidx.compose.material.FilterChip
import androidx.compose.material.Surface
import androidx.compose.material.Text
import androidx.compose.material3.AssistChip
import androidx.compose.material3.MaterialTheme
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.saveable.rememberSaveable
import androidx.compose.runtime.setValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.res.stringArrayResource
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import com.example.jetpack_compose_all_in_one.R
import com.example.jetpack_compose_all_in_one.ui.components.LessonHeader
import com.example.jetpack_compose_all_in_one.ui.theme.Red500
import com.example.jetpack_compose_all_in_one.ui.theme.White
import com.example.jetpack_compose_all_in_one.ui.theme.dp_15
import com.example.jetpack_compose_all_in_one.utils.LogicPager

@Preview
@Composable
fun Lesson_2_Chapter_8_Chip() {
    LessonContent()
}

@Composable
private fun LessonContent() {
    val currentPage = rememberSaveable { mutableStateOf(0) }

    LogicPager(
        pageCount = 3,
        currentPage = currentPage
    ) {
        Column(
            Modifier
                .fillMaxSize()
                .padding(it)
        ) {
            LessonHeader(
                stringArrayResource(R.array.l2c8_header_text)[currentPage.value],
                Modifier
                    .fillMaxWidth()
                    .padding(dp_15),
                TextAlign.Center
            )

            when (currentPage.value) {
                0 -> ChipDemo1()
                1 -> ChipDemo2()
                2 -> ChipDemo3()
            }
        }
    }
}

@OptIn(ExperimentalLayoutApi::class, ExperimentalMaterialApi::class)
@Composable
fun ChipDemo3() {
    val context = LocalContext.current
    var selected by remember { mutableStateOf(false) }

    FlowRow(modifier = Modifier.fillMaxWidth()) {
        Chip(
            modifier = Modifier.padding(end = 5.dp),
            colors = ChipDefaults.chipColors(
                backgroundColor = Color(0xFF102B4E),
                contentColor = Color.White
            ),
            onClick = {
                Toast.makeText(context, "Chip clicked", Toast.LENGTH_SHORT).show()
            },
            content = { Text("Chip 1") }
        )

        Chip(
            modifier = Modifier.padding(end = 5.dp),
            colors = ChipDefaults.chipColors(
                backgroundColor = Color(0xFF102B4E),
                contentColor = Color.White
            ),
            leadingIcon = { R.drawable.ic_drop },
            onClick = {
                Toast.makeText(context, "Chip with icon clicked", Toast.LENGTH_SHORT).show()
            },
            content = { Text("Chip with Icon") }
        )

        AssistChip(
            modifier = Modifier.padding(end = 5.dp),
            label = { Text("Assist") },
            onClick = {
                Toast.makeText(context, "Assist Chip clicked", Toast.LENGTH_SHORT).show()
            }
        )

        FilterChip(
            modifier = Modifier.padding(end = 5.dp),
            colors = ChipDefaults.filterChipColors(
                backgroundColor = Color(0xFF102B4E),
                contentColor = White,
                selectedBackgroundColor = Red500
            ),
            selected = selected,
            onClick = {
                Toast.makeText(context, "Filter Chip clicked", Toast.LENGTH_SHORT).show()
                selected = true
            },
            content = { Text("Filter") }
        )
    }

}

@Preview
@Composable
fun ChipDemo2() {
    //Urvish

    val list: ArrayList<String> = arrayListOf("car", "bike", "food")
    LazyRow(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.SpaceEvenly) {
        items(list.size) {
            RandomCategoryChip(category = list[it], onExecuteSearch = { })
        }
    }
}

@Composable
fun RandomCategoryChip(
    category: String,
    onExecuteSearch: (String) -> Unit
) {
    val context = LocalContext.current
    Surface(
        modifier = Modifier.padding(end = 15.dp),
        elevation = 10.dp,
        shape = MaterialTheme.shapes.medium,
        color = MaterialTheme.colorScheme.primary
    ) {
        Row(
            modifier = Modifier
                .clickable(onClick = { Toast.makeText(context,category,Toast.LENGTH_SHORT).show()
                }),

        ) {
            Text(
                text = category,
                style = MaterialTheme.typography.bodyMedium,
                color = Color.White,
                modifier = Modifier.padding(8.dp)
            )
        }
    }
}


enum class Chips(selected: Boolean){
    None(false),
    Work(false),
    Class(false),
    Casual(false),
    Hobby(selected = false)
}

fun getListOfChips(): List<Chips> = listOf(Chips.None, Chips.Work, Chips.Class, Chips.Casual, Chips.Hobby)

@Preview()
@Composable
fun ChipDemo1(
    name: String = "Dummy",
    isSelected: Boolean = false,
onChipSelected: () -> Unit = {}) {



    val selectedChip by rememberSaveable {
        mutableStateOf(Chips.None)
    }

    LazyRow{
    }
}

@OptIn(ExperimentalMaterialApi::class)
@Composable
fun CustomChip(name: String = "Dummy",isSelected: Boolean = false,
               onChipSelected: () -> Unit = {}){
    Chip(onClick = { onChipSelected.invoke() },

        ) {
        Text(text = name, style = MaterialTheme.typography.bodyMedium)
    }
}
