package ir.amirsobhan.wallpaperapp.Model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class ApiResult {

    @SerializedName("ok")
    @Expose
    private Boolean ok;
    @SerializedName("token")
    @Expose
    private String token;
    @SerializedName("des")
    @Expose
    private String des;

    public Boolean getOk() {
        return ok;
    }

    public void setOk(Boolean ok) {
        this.ok = ok;
    }

    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }

    public String getDes() {
        return des;
    }

    public void setDes(String des) {
        this.des = des;
    }

    @Override
    public String toString() {
        return "ApiResult{" +
                "ok=" + ok +
                ", token='" + token + '\'' +
                ", des='" + des + '\'' +
                '}';
    }
}