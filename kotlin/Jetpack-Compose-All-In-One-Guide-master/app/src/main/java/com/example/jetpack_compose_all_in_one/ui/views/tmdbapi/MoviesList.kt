package com.example.jetpack_compose_all_in_one.ui.views.tmdbapi

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.example.jetpack_compose_all_in_one.features.tmdb_using_flows_paging3.tmdbapi.TmdbResponse
import com.example.jetpack_compose_all_in_one.ui.components.TextButton

@Composable
fun MoviesList(
    dataResult: TmdbResponse,
    onPrevPage: () -> Unit,
    onNextPage: () -> Unit
) {
    Column(
        horizontalAlignment = Alignment.CenterHorizontally
    ) {
        Text("Popular movies", fontSize = 32.sp, fontWeight = FontWeight.Bold)

        LazyColumn(
            Modifier
                .fillMaxWidth()
                .weight(1f),
            verticalArrangement = Arrangement.spacedBy(16.dp)
        ) {
            items(dataResult.results) {
                MovieCard(data = it)
            }
        }

        Row(
            Modifier.fillMaxWidth(),
            horizontalArrangement = Arrangement.SpaceEvenly,
            verticalAlignment = Alignment.CenterVertically
        ) {
            TextButton(
                text = "Prev",
                onClick = { onPrevPage() },
                enabled = dataResult.page > 1)
            Text("Page ${dataResult.page}")
            TextButton(
                text = "Next",
                onClick = { onNextPage() },
                enabled = dataResult.page < dataResult.totalPages)
        }
    }
}