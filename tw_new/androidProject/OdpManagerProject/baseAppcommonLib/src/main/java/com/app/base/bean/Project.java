package com.app.base.bean;

import java.io.Serializable;
import java.util.List;

/**
 * 项目实体类
 */

public class Project implements Serializable {
    private String id;
    private String name;
    private boolean isSelect;
    /**
     * project_id : 1
     * project_name : 企擎
     * project_desc : 企擎介绍
     * add_time : 1528254443
     */

    private String project_id;
    private String project_name;
    private String project_desc;
    private String add_time;

    private List<StructureBean> structure;

    public List<StructureBean> getStructure() {
        return structure;
    }

    public void setStructure(List<StructureBean> structure) {
        this.structure = structure;
    }

    public boolean isSelect() {
        return isSelect;
    }

    public void setSelect(boolean select) {
        isSelect = select;
    }

    private String type;



    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getProject_id() {
        return project_id;
    }

    public void setProject_id(String project_id) {
        this.project_id = project_id;
    }

    public String getProject_name() {
        return project_name;
    }

    public void setProject_name(String project_name) {
        this.project_name = project_name;
    }

    public String getProject_desc() {
        return project_desc;
    }

    public void setProject_desc(String project_desc) {
        this.project_desc = project_desc;
    }

    public String getAdd_time() {
        return add_time;
    }

    public void setAdd_time(String add_time) {
        this.add_time = add_time;
    }
}
