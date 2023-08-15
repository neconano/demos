package com.zj.play.home

import android.content.Context
import android.view.ViewGroup
import android.widget.ImageView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.youth.banner.adapter.BannerAdapter
import com.zj.core.util.checkNetworkAvailable
import com.zj.core.util.showToast
import com.zj.model.room.entity.BannerBean
import com.zj.play.R
import com.zj.play.article.ArticleActivity

open class ImageAdapter(private val mContext: Context, mData: List<BannerBean>) :
    BannerAdapter<BannerBean?, ImageAdapter.BannerViewHolder?>(mData) {
    //创建ViewHolder，可以用viewType这个字段来区分不同的ViewHolder
    override fun onCreateHolder(
        parent: ViewGroup,
        viewType: Int
    ): BannerViewHolder {
        val imageView = ImageView(parent.context).apply {
            //注意，必须设置为match_parent，这个是viewpager2强制要求的
            layoutParams = ViewGroup.LayoutParams(
                ViewGroup.LayoutParams.MATCH_PARENT,
                ViewGroup.LayoutParams.MATCH_PARENT
            )
            scaleType = ImageView.ScaleType.CENTER_CROP
        }

        return BannerViewHolder(imageView)
    }

    class BannerViewHolder(view: ImageView) :
        RecyclerView.ViewHolder(view) {
        var imageView: ImageView = view
    }

    override fun onBindView(
        holder: BannerViewHolder?,
        data: BannerBean?,
        position: Int,
        size: Int
    ) {
        holder?.imageView?.apply {
            Glide.with(mContext)
                .load(if (data?.filePath == null) data?.imagePath else data.filePath)
                .into(this)
            setOnClickListener {
                if (!mContext.checkNetworkAvailable()) {
                    mContext.showToast(mContext.getString(R.string.no_network))
                    return@setOnClickListener
                }
                ArticleActivity.actionStart(
                    mContext,
                    data?.title ?: "",
                    data?.url ?: "www.baidu.com"
                )
            }
        }
    }
}