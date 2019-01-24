package app.odp.qidu.activity;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.AnnouncementBean;
import com.app.base.bean.FilesBean;
import com.app.base.netUtil.NoticeHttpUtil;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.TimeUtil;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.common.lib.basemvp.presenter.BasePresenter;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import choose.lm.com.fileselector.model.FileInfo;
import io.reactivex.observers.DisposableObserver;

/**
 * 公告通知-详情
 */

public class AnnouncementDetailsActivity extends BaseShowImgAndFileActivity<BasePresenter>{
    private TextView show_img_title,show_file_title,edit_publish_content,publish_title,time;
    private String id;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        id=getIntent().getStringExtra(IntentParams.KEY_ID);
        View layout_parent=findView(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setTextColor(getActivity().getResources().getColor(R.color.black));
        titleCenter.setText("公告详情");
        ImageView back=findView(R.id.title_left_image);
        back.setImageResource(R.drawable.icon_back_black);
        back.setOnClickListener(v -> {
            finish();
        });
        publish_title=findView(R.id.publish_title);
        edit_publish_content=findView(R.id.edit_publish_content);
        show_img_title=findView(R.id.show_img_title);
        show_file_title=findView(R.id.show_file_title);
        show_img_title.setText("公告图片");
        show_file_title.setText("公告文件");
        time=findView(R.id.time);
        initPictureAndFile();

        /*List<String> imgList=new ArrayList<>();
        for(int i=0;i<4;i++){
            imgList.add("");
        }
        imgAdapter.refreshData(imgList);
        fileAdapter.refreshData(imgList);*/
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_announcement_details,null);
    }

    @Override
    protected BasePresenter initPresenter() {
        return new BasePresenter() {
            @Override
            public void onCreate() {

            }

            @Override
            public void loadData() {
                showProgressDialog();
                HashMap<String,String> hashMap=new HashMap<>();
                hashMap.put("id",id);
                NoticeHttpUtil.getInstance().getNoticeDetails(hashMap, new DisposableObserver<String>() {
                    @Override
                    public void onNext(String data) {
                        dismissProgressDialog();
                        AnnouncementBean announcementBean=null;
                        if(!TextUtils.isEmpty(data)&&!data.equals("")){
                            try {
                                JSONObject object=new JSONObject(data);
                                String str=object.getString("list");
                                if(str!=null){
                                    announcementBean= GsonUtil.getObject(str,AnnouncementBean.class);
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }
                        if(announcementBean!=null){
                            getNoticeDetails(announcementBean);
                        }
                    }
                    @Override
                    public void onError(Throwable e) {
                        dismissProgressDialog();
                    }
                    @Override
                    public void onComplete() {

                    }
                },String.class);
            }
        };
    }
    public void getNoticeDetails(AnnouncementBean announcementBean) {
        publish_title.setText(announcementBean.getBulletin_title());
        edit_publish_content.setText(announcementBean.getBulletin_content());
        time.setText(TimeUtil.getFormatCommentTime(Long.parseLong(announcementBean.getBulletin_post_at())*1000));
        List<FilesBean> task_pic_urls=announcementBean.getImages();
        if(task_pic_urls!=null){
            List<LocalMedia> imgList=new ArrayList<>();
            for(int i=0;i<task_pic_urls.size();i++){
                LocalMedia localMedia=new LocalMedia();
                localMedia.setPath(HttpUrl.HOST+task_pic_urls.get(i).getPath());
                localMedia.setImageUrl(task_pic_urls.get(i).getPath());
                imgList.add(localMedia);
            }
            imgAdapter.refreshData(imgList);
            imgAdapter.notifyDataSetChanged();
        }
        List<FilesBean> task_file_urls=announcementBean.getFiles();
        if(task_file_urls!=null){
            List<FileInfo> listFiles=new ArrayList<>();
            for(int i=0;i<task_file_urls.size();i++){
                FileInfo fileInfo=new FileInfo();
                fileInfo.setFileUrl(task_file_urls.get(i).getPath());
                /*String path=fileInfo.getFileUrl();
                String b = path.substring(path.lastIndexOf("/") + 1, path.length());*/
                String b=task_file_urls.get(i).getName();
                fileInfo.setFile_name(b);
                String fileType = b.substring(b.lastIndexOf(".") + 1, b.length());
                if(!TextUtils.isEmpty(fileType)){
                    fileInfo.setFile_type(fileType);
                }
                listFiles.add(fileInfo);
            }
            fileAdapter.refreshData(listFiles);
            fileAdapter.notifyDataSetChanged();
        }

    }
}
