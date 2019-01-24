package app.odp.qidu.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.app.base.utils.GlideRoundTransform;
import com.app.base.utils.HttpUrl;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.global.AppUtils;
import com.luck.picture.lib.config.PictureMimeType;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.tools.ScreenUtils;

import org.json.JSONArray;

import java.io.File;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import app.odp.qidu.R;
import choose.lm.com.fileselector.model.FileInfo;
import choose.lm.com.fileselector.utils.DateUtil;

/**
 *图片-文件添加适配器
 */
public class GridFileAdapter extends
        RecyclerView.Adapter<GridFileAdapter.ViewHolder> {
    public final int TYPE_CAMERA = 1;
    public final int TYPE_PICTURE = 2;
    private LayoutInflater mInflater;
    private List<FileInfo> list = new ArrayList<>();
    private int selectMax = 8;
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
    public GridFileAdapter(Context context, onAddPicClickListener mOnAddPicClickListener) {
        this.mContext=context;
        itemWidth=(ScreenUtils.getScreenWidth(mContext)- ScreenUtils.dip2px(mContext,118))/4;
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

    public void setList(List<FileInfo> list) {
        this.list=list;
    }
    public void appendData(List<FileInfo> list){
        this.list.addAll(list);
    }
    public List<FileInfo> getDataList(){
        return list;
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        TextView tipsProgress;
        ImageView mImg;
        LinearLayout ll_del;
        TextView file_name;
        public ViewHolder(View view) {
            super(view);
            mImg = (ImageView) view.findViewById(R.id.img);
            ll_del = (LinearLayout) view.findViewById(R.id.ll_del);
            tipsProgress= (TextView) view.findViewById(R.id.tips_progress);
            file_name=view.findViewById(R.id.file_name);
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
        //view.getLayoutParams().height = itemHeight;
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
        params.width=itemWidth- com.common.lib.utils.ScreenUtils.dp2px(mContext,8);
        params.height=itemWidth- com.common.lib.utils.ScreenUtils.dp2px(mContext,8);
        viewHolder.mImg.setLayoutParams(params);
        viewHolder.file_name.setVisibility(View.VISIBLE);
        //少于8张，显示继续添加的图标
        if (getItemViewType(position) == TYPE_CAMERA) {

            viewHolder.file_name.setText("");
            viewHolder.mImg.setImageResource(R.drawable.icon_upload_add);
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
            FileInfo item = list.get(position);
            viewHolder.tipsProgress.setOnClickListener(null);
            if(!item.isUploadFinish()&&item.getProgress()!=null){
                viewHolder.tipsProgress.setVisibility(View.VISIBLE);
                viewHolder.tipsProgress.setText(item.getProgress()+"\n"+"正在上传");
            }else {
                if(item.isUploadFinish()&&!item.isUploadFailure()){
                    viewHolder.tipsProgress.setVisibility(View.VISIBLE);
                    viewHolder.tipsProgress.setText("上传完成");
                }else if(!item.isUploadFinish()&&item.isUploadFailure()){
                    viewHolder.tipsProgress.setVisibility(View.VISIBLE);
                    viewHolder.tipsProgress.setText("上传失败\n继续上传");
                    viewHolder.tipsProgress.setTag(position);
                    viewHolder.tipsProgress.setOnClickListener(reUploadListener);
                }else {
                    viewHolder.tipsProgress.setVisibility(View.GONE);
                }
            }
            /*if(item.getFileUrl()!=null&&item.getFile_path()==null){//线上地址存在的时候
                String path=item.getFileUrl();
                String b = path.substring(path.lastIndexOf("/") + 1, path.length());
                item.setFile_name(b);
                String suffixes="avi|mpeg|3gp|mp3|mp4|wav|jpeg|gif|jpg|png|apk|exe|pdf|rar|zip|docx|doc";
                Pattern pat=Pattern.compile("[\\w]+[\\.]("+suffixes+")");//正则判断
                Matcher mc=pat.matcher(b);//条件匹配
                while(mc.find()){
                    String substring = mc.group();//截取文件名后缀名
                    Log.e("substring:", substring);
                    item.setFile_type(substring);
                }
            }*/
            if (FileInfo.FileType.WORD.equals(item.getFile_type())) {
                viewHolder.mImg.setImageResource(R.drawable.ico_word);
            } else if (FileInfo.FileType.EXCEL.equals(item.getFile_type())) {
                viewHolder.mImg.setImageResource(R.drawable.ico_excel);
            } else if (FileInfo.FileType.PDF.equals(item.getFile_type())) {
                viewHolder.mImg.setImageResource(R.drawable.ico_pdf);
            } else if (FileInfo.FileType.PPT.equals(item.getFile_type())) {
                viewHolder.mImg.setImageResource(R.drawable.ico_ppt);
            } else if (FileInfo.FileType.VIDEO.equals(item.getFile_type())) {
                Glide.with(viewHolder.itemView.getContext())
                        .load(item.getFile_thumnbail())
                        .apply(options)
                        .into(viewHolder.mImg);
            } else if (FileInfo.FileType.IMAGE.equals(item.getFile_type())) {
                if(item.getFileUrl()!=null&&item.getFile_path()==null){
                    Glide.with(viewHolder.itemView.getContext())
                            .load(HttpUrl.HOST+item.getFileUrl())
                            .apply(options)
                            .into(viewHolder.mImg);
                }else {
                    Glide.with(viewHolder.itemView.getContext())
                            .load(item.getFile_path())
                            .apply(options)
                            .into(viewHolder.mImg);
                }
            } else if (FileInfo.FileType.MP3.equals(item.getFile_type())) {
                viewHolder.mImg.setImageResource(R.drawable.ico_mp3);
            } else {
                viewHolder.mImg.setImageResource(R.drawable.ico_other);
            }
            viewHolder.file_name.setText(item.getFile_name()+"");
            viewHolder.mImg.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if(item.getFile_path()==null&&item.getFileUrl()!=null){
                        AppUtils.openBrowser(mContext, HttpUrl.HOST+item.getFileUrl());
                    }else if(item.getFile_path()!=null){
                        AppUtils.openFileByPath(mContext,item.getFile_path());
                    }
                }
            });
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
        String fileUrls="";//a,c,z
        for(int i=0;i<list.size();i++){
            if(list.get(i).getFileUrl()!=null&& !TextUtils.isEmpty(list.get(i).getFileUrl())){
                if(i==0){
                    fileUrls=list.get(i).getFileUrl();
                }else {
                    fileUrls=fileUrls+","+list.get(i).getFileUrl();
                }
            }
        }
        return fileUrls;
    }

}
