package com.app.base.bean;

import java.util.List;

/**
 * 计划详情里面的实体类型
 */

public class PlanSubBean {
    private List<Plan> sub;
    private int plan_record_total;

    public List<Plan> getSub() {
        return sub;
    }

    public void setSub(List<Plan> sub) {
        this.sub = sub;
    }

    public int getPlan_record_total() {
        return plan_record_total;
    }

    public void setPlan_record_total(int plan_record_total) {
        this.plan_record_total = plan_record_total;
    }
}
