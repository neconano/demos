package com.smarttoolfactory.tutorial1_1basics.chapter2_material_widgets

import android.content.res.Configuration
import android.widget.Toast
import androidx.compose.foundation.Image
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.material.Icon
import androidx.compose.material.IconButton
import androidx.compose.material.Scaffold
import androidx.compose.material.Snackbar
import androidx.compose.material.SnackbarHost
import androidx.compose.material.Text
import androidx.compose.material.TopAppBar
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Home
import androidx.compose.material.icons.filled.Menu
import androidx.compose.material.icons.filled.Message
import androidx.compose.material.icons.filled.Settings
import androidx.compose.material.rememberScaffoldState
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.tooling.preview.Devices
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.compose.rememberNavController
import com.smarttoolfactory.tutorial1_1basics.R
import com.smarttoolfactory.tutorial1_1basics.ui.ComposeTutorialsTheme
import com.smarttoolfactory.tutorial1_1basics.ui.components.DrawerButton
import kotlinx.coroutines.launch

@Preview
@Composable
fun Tutorial2_9Screen1() {
    TutorialContent()
}

@Composable
private fun TutorialContent() {

    var currentRoute by remember { mutableStateOf(Routes.HOME_ROUTE) }
    val scaffoldState = rememberScaffoldState()
    val navController = rememberNavController()
    val coroutineScope = rememberCoroutineScope()
    val openDrawer: () -> Unit = { coroutineScope.launch { scaffoldState.drawerState.open() } }
    val closeDrawer: () -> Unit = { coroutineScope.launch { scaffoldState.drawerState.close() } }

    val context = LocalContext.current

    Scaffold(
        scaffoldState = scaffoldState,
        drawerContent = {
            AppDrawer(
                currentRoute = currentRoute,
                navigateToHome = {
                    currentRoute = Routes.HOME_ROUTE
                    navController.popBackStack()
                    navController.navigate(currentRoute)
                },
                navigateToSettings = {
                    currentRoute = Routes.SETTINGS_ROUTE
                    navController.popBackStack()
                    navController.navigate(currentRoute)
                },
                closeDrawer = closeDrawer
            )
        },
        topBar = {
            TopAppBar(
                title = {
                    Text("Side Navigation")
                },
                navigationIcon = {
                    IconButton(onClick = openDrawer) {
                        Icon(
                            imageVector = Icons.Filled.Menu,
                            contentDescription = null
                        )
                    }
                },
                actions = {
                    IconButton(onClick = {
                        // show snackbar as a suspend function
                        coroutineScope.launch {
                            scaffoldState.snackbarHostState.showSnackbar("Snackbar")
                        }
                    }) {
                        Icon(
                            imageVector = Icons.Filled.Message,
                            contentDescription = null
                        )
                    }
                }
            )
        },
        snackbarHost = {
            SnackbarHost(hostState = it) { snackbarData ->
                Snackbar(modifier = Modifier.padding(4.dp),
                    action = {
                        Text(text = "Action",
                            modifier = Modifier
                                .clickable {
                                    Toast
                                        .makeText(
                                            context,
                                            "Action invoked",
                                            Toast.LENGTH_SHORT
                                        )
                                        .show()
                                }
                                .padding(4.dp)
                        )
                    }) {
                    Text(snackbarData.message)
                }
            }
        }
    ) {
        NavHost(
            navController = navController,
            startDestination = Routes.HOME_ROUTE
        ) {
            composable(Routes.HOME_ROUTE) {
                HomeComponent()
            }

            composable(Routes.SETTINGS_ROUTE) {
                SettingsComponent()
            }
        }
    }
}

/**
 * Content of side navigation
 */
@Composable
fun AppDrawer(
    currentRoute: String,
    navigateToHome: () -> Unit,
    navigateToSettings: () -> Unit,
    closeDrawer: () -> Unit
) {

    Column(modifier = Modifier.fillMaxSize()) {
        DrawerHeader()
        DrawerButton(
            icon = Icons.Filled.Home,
            label = "Home",
            isSelected = currentRoute == Routes.HOME_ROUTE,
            action = {
                if (currentRoute != Routes.HOME_ROUTE) {
                    navigateToHome()
                }
                closeDrawer()
            }
        )

        DrawerButton(
            icon = Icons.Filled.Settings,
            label = "Settings",
            isSelected = currentRoute == Routes.SETTINGS_ROUTE,
            action = {
                if (currentRoute != Routes.SETTINGS_ROUTE) {
                    navigateToSettings()
                }
                closeDrawer()
            }
        )
    }
}

@Preview
@Preview("dark", uiMode = Configuration.UI_MODE_NIGHT_YES)
@Preview(device = Devices.PIXEL_C)
@Composable
private fun AppDrawerPreview() {
    ComposeTutorialsTheme {
        AppDrawer(
            currentRoute = Routes.HOME_ROUTE,
            navigateToHome = {},
            navigateToSettings = {},
            closeDrawer = {}
        )
    }
}

@Composable
private fun DrawerHeader() {

    Box(contentAlignment = Alignment.BottomStart, modifier = Modifier.background(Color.Green)) {
        Image(
            contentScale = ContentScale.Crop,
            modifier = Modifier.height(160.dp),
            painter = painterResource(id = R.drawable.drawer_bg2),
            contentDescription = null
        )

        Column(modifier = Modifier.padding(8.dp)) {
            Spacer(modifier = Modifier.height(8.dp))
            Image(
                modifier = Modifier
                    .size(70.dp)
                    .clip(CircleShape),
                painter = painterResource(id = R.drawable.avatar_1_raster),
                contentDescription = null
            )

            Spacer(modifier = Modifier.height(4.dp))
            Text(text = "Smart Tool Factory", color = Color.White)
            Text(text = "smarttoolfactory@icloud.com", color = Color.White)
        }
    }
}

@Preview
@Preview("dark", uiMode = Configuration.UI_MODE_NIGHT_YES)
@Preview(device = Devices.PIXEL_C)
@Composable
private fun DrawerHeaderPreview() {
    ComposeTutorialsTheme {
        DrawerHeader()
    }
}


@Preview
@Preview("dark", uiMode = Configuration.UI_MODE_NIGHT_YES)
@Preview(device = Devices.PIXEL_C)
@Composable
private fun DrawerButtonPreview() {
    ComposeTutorialsTheme {
        DrawerButton(
            icon = Icons.Filled.Home,
            label = "Home",
            isSelected = true,
            action = {

            }
        )
    }
}

@Composable
fun HomeComponent() {
    Box(
        contentAlignment = Alignment.Center,
        modifier = Modifier
            .fillMaxSize()
            .background(Color(0xff6D4C41))
    ) {
        Text(color = Color.White, text = "Home", fontSize = 50.sp, fontWeight = FontWeight.Bold)
    }
}

@Preview
@Preview("dark", uiMode = Configuration.UI_MODE_NIGHT_YES)
@Preview(device = Devices.PIXEL_C)
@Composable
private fun HomeComponentPreview() {
    ComposeTutorialsTheme {
        HomeComponent()
    }
}

@Composable
fun SettingsComponent() {
    Box(
        contentAlignment = Alignment.Center,
        modifier = Modifier
            .fillMaxSize()
            .background(Color(0xffFF6F00))
    ) {
        Text(color = Color.White, text = "Settings", fontSize = 50.sp, fontWeight = FontWeight.Bold)
    }
}

@Preview
@Preview("dark", uiMode = Configuration.UI_MODE_NIGHT_YES)
@Preview(device = Devices.PIXEL_C)
@Composable
private fun SettingsComponentPreview() {
    ComposeTutorialsTheme {
        SettingsComponent()
    }
}

object Routes {
    const val HOME_ROUTE = "Home"
    const val SETTINGS_ROUTE = "Settings"
}