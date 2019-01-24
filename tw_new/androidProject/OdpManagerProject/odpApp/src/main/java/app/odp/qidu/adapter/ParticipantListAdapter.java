package app.odp.qidu.adapter;

import android.content.Context;
import android.util.Log;
import android.view.View;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.Participant;
import com.app.base.bean.UserRealm;
import com.app.base.flow.FlowTagLayout;
import com.common.lib.utils.ToastUtils;

import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;

//各个部门参与者列表
public class ParticipantListAdapter extends CommonAdapter<Participant> {

    public ParticipantListAdapter(Context context) {
        super(context, R.layout.layout_participant_item);
    }
    //返回参与部门人员
    public List<UserRealm> getSelectUser(){
        List<UserRealm> selectUser=new ArrayList<>();
        for(int i=0;i<mDatas.size();i++){
            List<UserRealm> list=mDatas.get(i).getUserList();
            if(list!=null){
                for(int k=0;k<list.size();k++){
                    if(list.get(k).isSelect()){
                        selectUser.add(list.get(k));
                    }
                }
            }
        }
        return selectUser;
    }

    //设置默认选中的人员
    public void setSelectUser(List<UserRealm> selectedUser){
        //返回数据缺少一个department_id
        for(int i=0;i<mDatas.size();i++){
            for(int k=0;k<selectedUser.size();k++){
                if(mDatas.get(i).getDepartment_id().equals(selectedUser.get(k).getDepartment_id())){//如果同部门
                    List<UserRealm> userRealmList=mDatas.get(i).getUserList();
                    if(userRealmList!=null&&!userRealmList.isEmpty()){
                        for(int j=0;j<userRealmList.size();j++){
                            if(userRealmList.get(j).getMember_id().equals(selectedUser.get(k).getMember_id())){//id一样
                                mDatas.get(i).getUserList().get(j).setSelect(true);
                            }
                        }
                    }

                }
            }
        }
        notifyDataSetChanged();
    }
    @Override
    protected void convert(ViewHolder holder, Participant data, int position) {
        TextView tag_client=holder.getView(R.id.tag_client);
        tag_client.setText(data.getDepartment_name());
        tag_client.setCompoundDrawablePadding(10);


        if(data.getUserList()==null){
            return;
        }
        FlowTagLayout tagLayout=holder.getView(R.id.color_flow_layout);
        TagAdapter mColorTagAdapter = new TagAdapter(mContext,FlowTagLayout.FLOW_TAG_CHECKED_MULTI);
        mColorTagAdapter.setOnSelectClickListener(new TagAdapter.OnSelectClickListener() {
            @Override
            public void onSelectItemClick(List<UserRealm> selectList) {
                if(!selectList.isEmpty()){
                    tag_client.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_checked,0,0,0);
                }else {
                    tag_client.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_unchecked,0,0,0);
                }
            }
        });
        tagLayout.setAdapter(mColorTagAdapter);
        mColorTagAdapter.onlyAddAll(data.getUserList());
        tag_client.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                int size=data.getUserList().size();
                int selectSize=mColorTagAdapter.getSelectList().size();

                if(size==selectSize){//全选
                    tag_client.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_unchecked,0,0,0);
                    mColorTagAdapter.setAllunSelect();
                }else {//全不选
                    tag_client.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_checked,0,0,0);
                    mColorTagAdapter.setAllSelect();
                }

            }
        });
    }
    //private int selectPosition=-1;
    /*private ListView listView;
    public EditPlanListAdapter(ListView view, Collection<String> mDatas) {
        super(view, mDatas, R.layout.layout_publish_plan_item);
        this.listView=view;
    }

    @Override
    public void convert(AdapterHolder holder, int position, boolean isScrolling) {
        String itemData = (String)getItem(position);
        holder.setText(R.id.plan_order,"计划"+position);
        EditText editText=holder.getView(R.id.edit_plan_content);
        View delete_plan=holder.getView(R.id.delete_plan);
        delete_plan.setOnClickListener(v -> {
            ToastUtils.show("点击有反应没");
            if(mDatas.size()>0){
                mDatas.remove(position);
                notifyDataSetChanged();
                ListGridUtils.setListViewHeightBasedOnChildren(listView);
            }
        });
    }*/

}
