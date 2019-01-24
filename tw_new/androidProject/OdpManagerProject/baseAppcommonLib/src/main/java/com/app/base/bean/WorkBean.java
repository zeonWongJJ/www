package com.app.base.bean;

import java.util.List;

/**
 * Created by 7du-28 on 2018/6/21.
 */

public class WorkBean {

    /**
     * plan_avg_score : 2.17
     * grade_num : [{"grade":"A级评定","num":1},{"grade":"B级评定","num":1},{"grade":"C级评定","num":1},{"grade":"D级评定","num":1},{"grade":"E级评定","num":2}]
     * work_total_date : 4
     * work_total_time : 39
     */

    private double plan_avg_score;
    private String work_total_date;
    private int work_total_time;
    private List<GradeNumBean> list;

    public List<GradeNumBean> getList() {
        return list;
    }

    public void setList(List<GradeNumBean> list) {
        this.list = list;
    }

    public double getPlan_avg_score() {
        return plan_avg_score;
    }

    public void setPlan_avg_score(double plan_avg_score) {
        this.plan_avg_score = plan_avg_score;
    }

    public String getWork_total_date() {
        return work_total_date;
    }

    public void setWork_total_date(String work_total_date) {
        this.work_total_date = work_total_date;
    }

    public int getWork_total_time() {
        return work_total_time;
    }

    public void setWork_total_time(int work_total_time) {
        this.work_total_time = work_total_time;
    }


    public static class GradeNumBean {
        /**
         * grade : A级评定
         * num : 1
         */

        private String grade;
        private int num;

        public String getGrade() {
            return grade;
        }

        public void setGrade(String grade) {
            this.grade = grade;
        }

        public int getNum() {
            return num;
        }

        public void setNum(int num) {
            this.num = num;
        }
    }
}
