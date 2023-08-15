package com.example.jetpack_compose_all_in_one.ui.views.news_ui.list

import android.util.Log
import androidx.activity.compose.BackHandler
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import com.example.jetpack_compose_all_in_one.features.debounce_search.SearchScreen
import com.example.jetpack_compose_all_in_one.features.debounce_search.SearchViewModel
import com.example.jetpack_compose_all_in_one.features.news_sample.data.data.LatestNewsResponse
import com.example.jetpack_compose_all_in_one.features.news_sample.data.data.News
import com.example.jetpack_compose_all_in_one.ui.views.news_ui.detail.DetailScreen

@Composable
fun LatestNewsPage(
    searchViewModel: SearchViewModel,
    viewModel: NewsViewModel
) {
    val result by viewModel.latestNewsResponse.observeAsState()

    Log.d("LatestNewsPage", "Latest news result: $result")

    LaunchedEffect(result) {
        viewModel.getLatestNews()
    }

    result?.let { latestNewsResponse ->
        Column {
            Text(text = "Latest News")
            Spacer(modifier = Modifier.height(16.dp))
            SearchScreen(searchViewModel){
                viewModel.searchNews(
                    it,
                    System.currentTimeMillis() - 14 * 86400000, // This is 2 weeks
                    System.currentTimeMillis()
                )
            }
            when (latestNewsResponse.status) {
                "ok" -> NewsList(newsData = latestNewsResponse)
                else -> Text(text = "Error: ${latestNewsResponse.status}")
            }
        }
    } ?: Text(text = "Loading")
}

@Composable
fun NewsList(
    newsData: LatestNewsResponse,
) {
    val openDetailUI = remember { mutableStateOf<News?>(null) }

    Box(Modifier.fillMaxSize()) {
        Column(horizontalAlignment = Alignment.CenterHorizontally) {
            LazyColumn(
                Modifier
                    .fillMaxWidth()
                    .weight(1f),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                items(newsData.news.size) {
                    NewsCard(
                        news = newsData.news[it]
                    ) { detail -> openDetailUI.value = detail }
                }
            }
        }
        openDetailUI.value?.let {
            DetailScreen(newsItem = it) { openDetailUI.value = null }
        }
    }
}