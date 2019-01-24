package app.odp.qidu.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.app.base.utils.GlideRoundTransform;
import com.app.base.utils.HttpUrl;
import com.app.base.widget.RoundImageView;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.RequestOptions;
import com.luck.picture.lib.config.PictureMimeType;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.tools.ScreenUtils;

import java.io.File;
import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;

/**
 *图片-文件添加适配器
 */
public class GridImageSelectAdapter extends
        RecyclerView.Adapter<GridImageSelectAdapter.ViewHolder> {
    public final int TYPE_CAMERA = 1;
    public final int TYPE_PICTURE = 2;
    private LayoutInflater mInflater;
    private List<LocalMedia> list = new ArrayList<>();
    private int selectMax = 9;
    private Context mContext;
    private int itemWidth;
    private RequestOptions options;
    /**
     * 点击添加图片跳转
     */
    private onAddPicClickListener mOnAddPicClickListener;

    public interface onAddPicClickListener {
        void onAddPicClick(int type, int position);
    }
    //paddingSpace是recyclerview左右距离屏幕的距离
    public GridImageSelectAdapter(Context context, onAddPicClickListener mOnAddPicClickListener) {
        this.mContext=context;
        //110
        itemWidth=(ScreenUtils.getScreenWidth(mContext)- ScreenUtils.dip2px(mContext,30))/3;
        mInflater = LayoutInflater.from(context);
        this.mOnAddPicClickListener = mOnAddPicClickListener;
        options = new RequestOptions()
                .transform(new GlideRoundTransform(mContext))
                .diskCacheStrategy(DiskCacheStrategy.ALL);
    }
    private View.OnClickListener reUploadListener;
    public void setReUploadListener(View.OnClickListener reUploadListener){
        this.reUploadListener=reUploadListener;
    }

    public void setSelectMax(int selectMax) {
        this.selectMax = selectMax;
    }

    public void setList(List<LocalMedia> list) {
        this.list = list;
    }
    public void appendList(List<LocalMedia> list){
        this.list.addAll(list);
    }
    public List<LocalMedia> getDataList(){
        return list;
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        TextView tipsProgress;
        RoundImageView mImg;
        LinearLayout ll_del;
        public ViewHolder(View view) {
            super(view);
            mImg = (RoundImageView) view.findViewById(R.id.img);
            ll_del = (LinearLayout) view.findViewById(R.id.ll_del);
            tipsProgress= (TextView) view.findViewById(R.id.tips_progress);
        }
    }

    @Override
    public int getItemCount() {
        if (list.size() < selectMax) {
            return list.size() + 1;
        } else {
            return list.size();
        }
    }

    @Override
    public int getItemViewType(int position) {
        if (isShowAddItem(position)) {
            return TYPE_CAMERA;
        } else {
            return TYPE_PICTURE;
        }
    }

    /**
     * 创建ViewHolder
     */
    @Override
    public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int i) {
        View view = mInflater.inflate(R.layout.layout_img_item,
                viewGroup, false);
        view.getLayoutParams().height = itemWidth;
        view.getLayoutParams().width = itemWidth;
        final ViewHolder viewHolder = new ViewHolder(view);
        //itemView 的点击事件
        if (mItemClickListener != null) {
            viewHolder.itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    mItemClickListener.onItemClick(viewHolder.getAdapterPosition(), v);
                }
            });
        }
        return viewHolder;
    }

    private boolean isShowAddItem(int position) {
        int size = list.size() == 0 ? 0 : list.size();
        return position == size;
    }

    /**
     * 设置值
     */
    @Override
    public void onBindViewHolder(final ViewHolder viewHolder, final int position) {
        RelativeLayout.LayoutParams params= (RelativeLayout.LayoutParams) viewHolder.mImg.getLayoutParams();
        params.width=itemWidth;
        params.height=itemWidth;
        viewHolder.mImg.setLayoutParams(params);
        //少于8张，显示继续添加的图标
        if (getItemViewType(position) == TYPE_CAMERA) {
            viewHolder.mImg.setImageResource(R.drawable.icon_add_dynaminc);
            viewHolder.mImg.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    mOnAddPicClickListener.onAddPicClick(0, viewHolder.getAdapterPosition());
                }
            });
            viewHolder.ll_del.setVisibility(View.INVISIBLE);
        } else {
            viewHolder.ll_del.setVisibility(View.VISIBLE);
            viewHolder.ll_del.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    mOnAddPicClickListener.onAddPicClick(1, viewHolder.getAdapterPosition());
                }
            });
            LocalMedia media = list.get(position);
            viewHolder.tipsProgress.setOnClickListener(null);
            if(!media.isUploadFinish()&&media.getProgress()!=null){
                viewHolder.tipsProgress.setVisibility(View.VISIBLE);
                viewHolder.tipsProgress.setText(media.getProgress()+"\n"+"正在上传");
            }else {
                if(media.isUploadFailure()){
                    viewHolder.tipsProgress.setVisibility(View.VISIBLE);
                    viewHolder.tipsProgress.setText("上传失败\n继续上传");
                    viewHolder.tipsProgress.setTag(position);
                    viewHolder.tipsProgress.setOnClickListener(reUploadListener);
                }else if(media.isUploadFinish()){
                    viewHolder.tipsProgress.setVisibility(View.VISIBLE);
                    viewHolder.tipsProgress.setText("上传完成");
                }else {
                    viewHolder.tipsProgress.setVisibility(View.GONE);
                }
            }
            if(media.getImageUrl()!=null&&media.getCompressPath()==null){
                Glide.with(viewHolder.itemView.getContext())
                        .load(HttpUrl.HOST+media.getImageUrl())
                        .apply(options)
                        .into(viewHolder.mImg);
            }else {
                int mimeType = media.getMimeType();
                String path = "";
                if (media.isCut() && !media.isCompressed()) {
                    // 裁剪过
                    path = media.getCutPath();
                } else if (media.isCompressed() || (media.isCut() && media.isCompressed())) {
                    // 压缩过,或者裁剪同时压缩过,以最终压缩过图片为准
                    path = media.getCompressPath();
                } else {
                    // 原图
                    path = media.getPath();
                }
                // 图片
                if (media.isCompressed()) {
                    Log.i("compress image result:", new File(media.getCompressPath()).length() / 1024 + "k");
                    Log.i("压缩地址::", media.getCompressPath());
                }

                Log.i("原图地址::", media.getPath());
                int pictureType = PictureMimeType.isPictureType(media.getPictureType());
                if (media.isCut()) {
                    Log.i("裁剪地址::", media.getCutPath());
                }

                if (mimeType == PictureMimeType.ofAudio()) {
                    viewHolder.mImg.setImageResource(R.drawable.audio_placeholder);
                } else {
                    Glide.with(viewHolder.itemView.getContext())
                            .load(path)
                            .apply(options)
                            .into(viewHolder.mImg);
                }
            }

        }
    }

    protected OnItemClickListener mItemClickListener;

    public interface OnItemClickListener {
        void onItemClick(int position, View v);
    }

    public void setOnItemClickListener(OnItemClickListener listener) {
        this.mItemClickListener = listener;
    }


    //获取上传成功后的文件地址合集
    public String getUploadUrls(){
        String imgUrls="";//a,c,z
        for(int i=0;i<list.size();i++){
            if(list.get(i).isImageUrl()!=null&& !TextUtils.isEmpty(list.get(i).isImageUrl())){
                if(i==0){
                    imgUrls=list.get(i).isImageUrl();
                }else {
                    imgUrls=imgUrls+","+list.get(i).isImageUrl();
                }
            }
        }
        return imgUrls;
    }
}
