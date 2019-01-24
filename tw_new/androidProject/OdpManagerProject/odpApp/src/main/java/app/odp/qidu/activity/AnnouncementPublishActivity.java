package app.odp.qidu.activity;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.AnnouncementBean;
import com.app.base.bean.FilesBean;
import com.app.base.bean.Notice;
import com.app.base.bean.UserRealm;
import com.app.base.flow.FlowTagLayout;
import com.app.base.mvp.contract.NoticeContract;
import com.app.base.mvp.presenter.NoticePresenterImpl;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.IntentParams;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.common.lib.basemvp.presenter.BasePresenter;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.TagAdapter;
import app.odp.qidu.adapter.TagAllUserAdapter;
import choose.lm.com.fileselector.model.FileInfo;

/**
 * 公告通知-发布
 */

public class AnnouncementPublishActivity extends BasePhotoFileActivity<NoticePresenterImpl> implements NoticeContract.View{
    private int type;
    public static int PUBLISH=0;
    public static int EDIT=1;
    private View publish;
    private EditText edit_publish_title,edit_publish_content;
    private String id;
    private TagAllUserAdapter mColorTagAdapter;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        type=getIntent().getIntExtra(IntentParams.KEY_PUBLISH_EDIT_ANNOUNCEMENT,0);
        View layout_parent=findView(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setTextColor(getResources().getColor(R.color.black));
        ImageView back=findView(R.id.title_left_image);
        back.setImageResource(R.drawable.icon_back_black);
        back.setOnClickListener(v -> {
            finish();
        });
        publish=findView(R.id.publish);

        edit_publish_title=findView(R.id.edit_publish_title);
        edit_publish_content=findView(R.id.edit_publish_content);
        initSelectPhoto();
        initSelectFile();

        FlowTagLayout tagLayout=findView(R.id.color_flow_layout);
        mColorTagAdapter = new TagAllUserAdapter(this);
        mColorTagAdapter.setOnSelectClickListener(new TagAllUserAdapter.OnSelectClickListener() {
            @Override
            public void onSelectItemClick(List<UserRealm> selectList) {

            }
        });
        tagLayout.setAdapter(mColorTagAdapter);

        publish.setOnClickListener(v -> {
            publishNotice();
        });
        mPresenter.departmentAndMembers();
        if(type==PUBLISH){
            titleCenter.setText("发布公告");
        }else if(type==EDIT){
            id=getIntent().getStringExtra(IntentParams.KEY_ID);
            titleCenter.setText("编辑公告");
            publish.setVisibility(View.GONE);
            TextView right=findView(R.id.title_right_text);
            right.setTextColor(getResources().getColor(R.color.blue));
            right.setText("完成");
            right.setOnClickListener(v -> {
                publishNotice();
            });
            showProgressDialog();
            HashMap<String,String> hashMap=new HashMap<>();
            hashMap.put("id",id);
            mPresenter.getNoticeDetails(hashMap);
        }
    }

    private void publishNotice(){
        String title=edit_publish_title.getText().toString();
        String content=edit_publish_content.getText().toString();
        if(title.length()<10){
            ToastUtils.show("公告主题不能少于10个字符");
            return;
        }
        if(content.length()<15){
            ToastUtils.show("公告内容不能少于15个字符");
            return;
        }
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("bulletin_title",title);
        hashMap.put("bulletin_content",content);
        List<UserRealm> selectUser=mColorTagAdapter.getSelectList();
        String userIds="";
        if(selectUser.size()>0){
            for(int i=0;i<selectUser.size();i++){
                if(i==0){
                    userIds=selectUser.get(i).getMember_id()+"";
                }else {
                    userIds = userIds + "," + selectUser.get(i).getMember_id();
                }
            }
        }
        if(TextUtils.isEmpty(userIds)){
            ToastUtils.show("请选择通知的人");
            return;
        }
        hashMap.put("bulletin_member",userIds);//公告通知人员,。通知所有人员可以传递*
        String imgUrls=imgAdapter.getUploadUrls();
        Log.i("aaaaaaaa","图片"+imgUrls);
        String fileUrls=fileAdapter.getUploadUrls();
        //hashMap.put("bulletin_annex","");//公告附件，图片、文件类型统一传递。上传文件成功后返回附件id
        if(!TextUtils.isEmpty(imgUrls)){
            hashMap.put("bulletin_images",imgUrls);
        }
        if(!TextUtils.isEmpty(fileUrls)){
            hashMap.put("bulletin_files",fileUrls);
        }

        boolean isEdit=false;
        if(type==PUBLISH){
            isEdit=false;
        }else if(type==EDIT){
            hashMap.put("id",id);
            isEdit=true;
        }
        showProgressDialog();
        mPresenter.publishNotice(isEdit,hashMap);
    }
    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_announcement_publish,null);
    }

    @Override
    protected NoticePresenterImpl initPresenter() {
        return new NoticePresenterImpl("");
    }

    @Override
    public void noticeListData(int pageIndex, List<Notice> list) {

    }

    @Override
    public void showNoticeListFailure(Throwable throwable) {

    }

    @Override
    public void showUserListSuccess(List<UserRealm> list) {
        mColorTagAdapter.onlyAddAll(list);
    }

    @Override
    public void publishNoticeSuccess() {
        dismissProgressDialog();
        if(type==EDIT){
            ToastUtils.show("编辑成功");
        }else {
            ToastUtils.show("发布成功");
        }
    }

    @Override
    public void failure() {
        dismissProgressDialog();
        if(type==EDIT){
            ToastUtils.show("编辑失败");
        }else {
            ToastUtils.show("发布失败");
        }
    }

    @Override
    public void getNoticeDetails(AnnouncementBean announcementBean) {
        dismissProgressDialog();
        if(announcementBean==null){
            return;
        }
        List<UserRealm> userRealms=announcementBean.getMembers();
        if(userRealms!=null){
            mColorTagAdapter.setSelectUser(userRealms);
        }
        edit_publish_title.setText(announcementBean.getBulletin_title());
        edit_publish_content.setText(announcementBean.getBulletin_content());
        List<FilesBean> task_pic_urls=announcementBean.getImages();
        if(task_pic_urls!=null){
            List<LocalMedia> imgList=new ArrayList<>();
            for(int i=0;i<task_pic_urls.size();i++){
                LocalMedia localMedia=new LocalMedia();
                localMedia.setPath(HttpUrl.HOST+task_pic_urls.get(i).getPath());
                localMedia.setImageUrl(task_pic_urls.get(i).getPath());
                imgList.add(localMedia);
            }
            imgAdapter.setList(imgList);
            imgAdapter.notifyDataSetChanged();
        }
        //mColorTagAdapter.set
        //mColorTagAdapter.onlyAddAll(tagsData);
        List<FilesBean> task_file_urls=announcementBean.getFiles();
        if(task_file_urls!=null){
            List<FileInfo> listFiles=new ArrayList<>();
            for(int i=0;i<task_file_urls.size();i++){
                FileInfo fileInfo=new FileInfo();
                fileInfo.setFileUrl(task_file_urls.get(i).getPath());
                //String path=fileInfo.getFileUrl();
                //String b = path.substring(path.lastIndexOf("/") + 1, path.length());
                String b=task_file_urls.get(i).getName();
                fileInfo.setFile_name(b);
                /*String suffixes="avi|mpeg|3gp|mp3|mp4|wav|jpeg|gif|jpg|png|apk|exe|pdf|rar|zip|docx|doc";
                Pattern pat=Pattern.compile("[\\w]+[\\.]("+suffixes+")");//正则判断
                Matcher mc=pat.matcher(b);//条件匹配
                while(mc.find()){
                    String substring = mc.group();//截取文件名后缀名
                    Log.e("substring:", substring);
                    fileInfo.setFile_type(substring);
                }*/
                String fileType = b.substring(b.lastIndexOf(".") + 1, b.length());
                if(!TextUtils.isEmpty(fileType)){
                    fileInfo.setFile_type(fileType);
                }
                listFiles.add(fileInfo);
            }
            fileAdapter.setList(listFiles);
            fileAdapter.notifyDataSetChanged();
        }

    }
}
