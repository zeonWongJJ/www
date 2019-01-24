package com.app.base.utils;

import com.app.base.bean.Participant;
import com.app.base.bean.TopMenuItem;
import com.app.base.bean.TypeSelect;
import com.app.base.bean.UserRealm;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by 7du-28 on 2017/8/24.
 */

public class DataUtils {
    public static final String WECHAT_APP_ID="wxeabc8436ab550bc3";

    public static final String WECHAT_SECRET_ID="ca9c7837e87471f29972dd99164c1a08";

    /*任务类型切换*/
    public static List<TopMenuItem> taskList(String action){
        if(action.equals(TopMenuItem.ALL_TASK)){
            return withoutAllTaskList();
        }else if(action.equals(TopMenuItem.PLAN_TASK)){
            return withoutPlanTaskList();
        }else if(action.equals(TopMenuItem.MY_TASK)){
            return withoutMyTaskList();
        }else if(action.equals(TopMenuItem.BILLBOARD)){
            return withoutBillboardTaskList();
        }else if(action.equals(TopMenuItem.MY_PUBLISH_TASK)){
            return withoutMyPublishTaskList();
        }
        return new ArrayList<>();
    }

    private static List<TopMenuItem> withoutAllTaskList(){
        List<TopMenuItem> list=new ArrayList<>();
        //TopMenuItem allTask=new TopMenuItem("全部任务","allTask");//全部任务
        TopMenuItem myTask=new TopMenuItem("我的任务",TopMenuItem.MY_TASK);//我的任务
        TopMenuItem planTask=new TopMenuItem("计划任务",TopMenuItem.PLAN_TASK);//计划任务
        TopMenuItem publishTask=new TopMenuItem("发布的任务",TopMenuItem.MY_PUBLISH_TASK);//我发布的任务
        TopMenuItem billboard=new TopMenuItem("任务榜单",TopMenuItem.BILLBOARD);//任务榜单
        list.add(myTask);
        list.add(planTask);
        list.add(publishTask);
        list.add(billboard);
        return list;
    }

    private static List<TopMenuItem> withoutMyTaskList(){
        List<TopMenuItem> list=new ArrayList<>();
        TopMenuItem allTask=new TopMenuItem("全部任务",TopMenuItem.ALL_TASK);//全部任务
        TopMenuItem planTask=new TopMenuItem("计划任务",TopMenuItem.PLAN_TASK);//计划任务
        TopMenuItem publishTask=new TopMenuItem("发布的任务",TopMenuItem.MY_PUBLISH_TASK);//我发布的任务
        TopMenuItem billboard=new TopMenuItem("任务榜单",TopMenuItem.BILLBOARD);//任务榜单
        list.add(allTask);
        list.add(planTask);
        list.add(publishTask);
        list.add(billboard);
        return list;
    }

    private static List<TopMenuItem> withoutPlanTaskList(){
        List<TopMenuItem> list=new ArrayList<>();
        TopMenuItem allTask=new TopMenuItem("全部任务",TopMenuItem.ALL_TASK);//全部任务
        TopMenuItem myTask=new TopMenuItem("我的任务",TopMenuItem.MY_TASK);//我的任务
        TopMenuItem publishTask=new TopMenuItem("发布的任务",TopMenuItem.MY_PUBLISH_TASK);//我发布的任务
        TopMenuItem billboard=new TopMenuItem("任务榜单",TopMenuItem.BILLBOARD);//任务榜单
        list.add(allTask);
        list.add(myTask);
        list.add(publishTask);
        list.add(billboard);
        return list;
    }

    private static List<TopMenuItem> withoutBillboardTaskList(){
        List<TopMenuItem> list=new ArrayList<>();
        TopMenuItem allTask=new TopMenuItem("全部任务",TopMenuItem.ALL_TASK);//全部任务
        TopMenuItem myTask=new TopMenuItem("我的任务",TopMenuItem.MY_TASK);//我的任务
        TopMenuItem planTask=new TopMenuItem("计划任务",TopMenuItem.PLAN_TASK);//计划任务
        TopMenuItem publishTask=new TopMenuItem("发布的任务",TopMenuItem.MY_PUBLISH_TASK);//我发布的任务
        list.add(allTask);
        list.add(myTask);
        list.add(planTask);
        list.add(publishTask);
        return list;
    }

    private static List<TopMenuItem> withoutMyPublishTaskList(){
        List<TopMenuItem> list=new ArrayList<>();
        TopMenuItem allTask=new TopMenuItem("全部任务",TopMenuItem.ALL_TASK);//全部任务
        TopMenuItem myTask=new TopMenuItem("我的任务",TopMenuItem.MY_TASK);//我的任务
        TopMenuItem planTask=new TopMenuItem("计划任务",TopMenuItem.PLAN_TASK);//计划任务
        TopMenuItem billboard=new TopMenuItem("任务榜单",TopMenuItem.BILLBOARD);//任务榜单
        list.add(allTask);
        list.add(myTask);
        list.add(planTask);
        list.add(billboard);
        return list;
    }


    /*任务详情-执行状态-弹窗数据*/

    public static List<TypeSelect> getTypeListAction(String action){
        if(action.equals(TypeSelect.acceptTask)){
            return withoutAcceptTask();
        }else if(action.equals(TypeSelect.giveUpTask)){
            return withoutGiveUpTask();
        }else if(action.equals(TypeSelect.actionRecord)){
            return withoutActionRecord();
        }else if(action.equals(TypeSelect.editProcess)){
            return withoutEditProcess();
        }else if(action.equals(TypeSelect.resetProcedure)){
            return withoutResetProcedure();
        }else if(action.equals(TypeSelect.cancelProcedure)){
            return withoutCancelProcedure();
        }else if(action.equals(TypeSelect.completeTask)){
            return completeTask();
        }else if(action.equals(TypeSelect.unAcceptTask)){
            return withoutUnAcceptTask();
        }
        return withoutAcceptTask();
    }
    /*List<TypeSelect> list=new ArrayList<>();
    list.add(new TypeSelect(TypeSelect.assignTask,"指派任务"));
        list.add(new TypeSelect(TypeSelect.acceptTask,"接手任务"));
        list.add(new TypeSelect(TypeSelect.giveUpTask,"放弃任务"));
        list.add(new TypeSelect(TypeSelect.actionRecord,"动作记录"));
        list.add(new TypeSelect(TypeSelect.editProcess,"编辑进度"));
        list.add(new TypeSelect(TypeSelect.resetProcedure,"恢复流程"));
        list.add(new TypeSelect(TypeSelect.cancelProcedure,"取消流程"));*/


    //已经被接手的状态，显示的列表项
    public static List<TypeSelect> withoutAcceptTask(){
        List<TypeSelect> list=new ArrayList<>();
        list.add(new TypeSelect(TypeSelect.giveUpTask,"放弃任务"));
        list.add(new TypeSelect(TypeSelect.actionRecord,"动作记录"));
        list.add(new TypeSelect(TypeSelect.editProcess,"编辑进度"));
        return list;
    }

    //未接手 放弃任务的时候显示的列表项
    public static List<TypeSelect> withoutUnAcceptTask(){
        List<TypeSelect> list=new ArrayList<>();
        list.add(new TypeSelect(TypeSelect.acceptTask,"接手任务"));
        list.add(new TypeSelect(TypeSelect.assignTask,"指派任务"));
        list.add(new TypeSelect(TypeSelect.actionRecord,"动作记录"));
        //list.add(new TypeSelect(TypeSelect.editProcess,"编辑进度"));
        //list.add(new TypeSelect(TypeSelect.resetProcedure,"恢复流程"));
        list.add(new TypeSelect(TypeSelect.cancelProcedure,"取消流程"));
        return list;
    }


    //未接手 放弃任务的时候显示的列表项
    public static List<TypeSelect> withoutGiveUpTask(){
        List<TypeSelect> list=new ArrayList<>();
        list.add(new TypeSelect(TypeSelect.acceptTask,"接手任务"));
        list.add(new TypeSelect(TypeSelect.assignTask,"指派任务"));
        list.add(new TypeSelect(TypeSelect.actionRecord,"动作记录"));
        //list.add(new TypeSelect(TypeSelect.editProcess,"编辑进度"));
        //list.add(new TypeSelect(TypeSelect.resetProcedure,"恢复流程"));
        list.add(new TypeSelect(TypeSelect.cancelProcedure,"取消流程"));
        return list;
    }
    public static List<TypeSelect> withoutActionRecord(){
        List<TypeSelect> list=new ArrayList<>();
        list.add(new TypeSelect(TypeSelect.acceptTask,"接手任务"));
        //list.add(new TypeSelect(TypeSelect.actionRecord,"动作记录"));
        list.add(new TypeSelect(TypeSelect.editProcess,"编辑进度"));
        list.add(new TypeSelect(TypeSelect.resetProcedure,"恢复流程"));
        list.add(new TypeSelect(TypeSelect.cancelProcedure,"取消流程"));
        return list;
    }
    public static List<TypeSelect> withoutEditProcess(){
        List<TypeSelect> list=new ArrayList<>();
        list.add(new TypeSelect(TypeSelect.acceptTask,"接手任务"));
        list.add(new TypeSelect(TypeSelect.actionRecord,"动作记录"));
        //list.add(new TypeSelect(TypeSelect.editProcess,"编辑进度"));
        list.add(new TypeSelect(TypeSelect.resetProcedure,"恢复流程"));
        list.add(new TypeSelect(TypeSelect.cancelProcedure,"取消流程"));
        return list;
    }

    //流程被取消的状态 只显示恢复流程
    public static List<TypeSelect> withoutCancelProcedure(){
        List<TypeSelect> list=new ArrayList<>();
        /*list.add(new TypeSelect(TypeSelect.acceptTask,"接手任务"));
        list.add(new TypeSelect(TypeSelect.actionRecord,"动作记录"));
        list.add(new TypeSelect(TypeSelect.editProcess,"编辑进度"));*/
        list.add(new TypeSelect(TypeSelect.resetProcedure,"恢复流程"));
        return list;
    }


    public static List<TypeSelect> withoutResetProcedure(){
        List<TypeSelect> list=new ArrayList<>();
        list.add(new TypeSelect(TypeSelect.acceptTask,"接手任务"));
        list.add(new TypeSelect(TypeSelect.actionRecord,"动作记录"));
        list.add(new TypeSelect(TypeSelect.editProcess,"编辑进度"));
        //list.add(new TypeSelect(TypeSelect.resetProcedure,"恢复流程"));
        list.add(new TypeSelect(TypeSelect.cancelProcedure,"取消流程"));
        return list;
    }
    //已经完成
    public static List<TypeSelect> completeTask(){
        List<TypeSelect> list=new ArrayList<>();

        list.add(new TypeSelect(TypeSelect.giveUpTask,"放弃任务"));
        list.add(new TypeSelect(TypeSelect.actionRecord,"动作记录"));
        list.add(new TypeSelect(TypeSelect.editProcess,"编辑进度"));
        list.add(new TypeSelect(TypeSelect.cancelProcedure,"取消流程"));
        return list;
    }



    public static List<Participant> getParticipantGroup(List<UserRealm> baseUserList){
        List<Participant> list=new ArrayList<>();
        List<Participant> participantList=new ArrayList<>();
        for(int i=0;i<baseUserList.size();i++){
            Participant participant=new Participant();
            participant.setDepartment_id(baseUserList.get(i).getDepartment_id());
            String departmentName="";
            if(baseUserList.get(i).getMajor()!=null){
                departmentName=baseUserList.get(i).getMajor();
            }else {
                departmentName=baseUserList.get(i).getDepartment_name();
            }
            participant.setDepartment_name(departmentName);
            list.add(participant);
        }
        //去重
        for (int i = 0; i < list.size(); i++)  //外循环是循环的次数
        {
            for (int j = list.size() - 1 ; j > i; j--)  //内循环是 外循环一次比较的次数
            {
                if (list.get(i).getDepartment_id().equals(list.get(j).getDepartment_id())){
                    list.remove(j);
                }
            }
        }
        //重新分组
        for(int i = 0; i < list.size(); i++){
            List<UserRealm> userRealmList=new ArrayList<>();
            for(int k=0;k<baseUserList.size();k++){
                if(list.get(i).getDepartment_id().equals(baseUserList.get(k).getDepartment_id())){
                    userRealmList.add(baseUserList.get(k));
                }
            }
            Participant participant=new Participant();
            participant.setDepartment_name(list.get(i).getDepartment_name());
            participant.setDepartment_id(list.get(i).getDepartment_id());
            participant.setUserList(userRealmList);
            participantList.add(participant);
        }
        return participantList;
    }



    //数字换成字母等级
    public static String getLevelByNum(float rating){
        String level="";
        if(rating==1){
            level="E";
        }else if(rating==2){
            level="D";
        }else if(rating==3){
            level="C";
        }else if(rating==4){
            level="B";
        }else if(rating==5){
            level="A";
        }
        return level;
    }
}
