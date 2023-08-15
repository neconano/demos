package com.jetpack.compose.learning.list.advancelist

import android.content.Context
import android.widget.Toast
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.paging.LoadState
import androidx.paging.PagingData
import androidx.paging.compose.LazyPagingItems
import androidx.paging.compose.collectAsLazyPagingItems
import androidx.paging.compose.items
import com.jetpack.compose.learning.list.advancelist.model.Movie
import com.jetpack.compose.learning.list.advancelist.uiclass.ErrorMessage
import com.jetpack.compose.learning.list.advancelist.uiclass.LoadingNextPageItem
import com.jetpack.compose.learning.list.advancelist.uiclass.MovieItem
import com.jetpack.compose.learning.list.advancelist.uiclass.PageLoader
import com.jetpack.compose.learning.list.advancelist.viewmodel.MovieViewModel
import kotlinx.coroutines.flow.Flow

@Composable
fun MovieList(modifier: Modifier = Modifier, viewModel: MovieViewModel, context: Context) {
    MovieInfoList(modifier, userList = viewModel.user, context)
}

@Composable
fun MovieInfoList(modifier: Modifier, userList: Flow<PagingData<Movie>>, context: Context) {
    val userListItems: LazyPagingItems<Movie> = userList.collectAsLazyPagingItems()

    LazyColumn {

        items(userListItems) { item ->
            item?.let {
                MovieItem(data = it, onClick = {
                    Toast.makeText(
                        context,
                        item.original_title,
                        Toast.LENGTH_SHORT
                    ).show()
                })
            }
        }

        userListItems.apply {
            when {
                loadState.refresh is LoadState.Loading -> {
                    item { PageLoader(modifier = Modifier.fillParentMaxSize()) }
                }
                loadState.append is LoadState.Loading -> {
                    item { LoadingNextPageItem(modifier) }
                }
                loadState.append is LoadState.Error -> {
                    val error = userListItems.loadState.append as LoadState.Error
                    item {
                        ErrorMessage(modifier = modifier,
                            message = error.error.localizedMessage!!,
                            onClickRetry = { retry() })
                    }
                }
            }
        }
    }
}