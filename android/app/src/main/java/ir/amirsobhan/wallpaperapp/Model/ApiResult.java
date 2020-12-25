package ir.amirsobhan.wallpaperapp.Model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class ApiResult {

    @SerializedName("ok")
    @Expose
    private Boolean ok;
    @SerializedName("code")
    @Expose
    private Integer code;
    @SerializedName("des")
    @Expose
    private String des;

    public Boolean getOk() {
        return ok;
    }

    public void setOk(Boolean ok) {
        this.ok = ok;
    }

    public Integer getCode() {
        return code;
    }

    public void setCode(Integer code) {
        this.code = code;
    }

    public String getDes() {
        return des;
    }

    public void setDes(String des) {
        this.des = des;
    }

}