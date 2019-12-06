package ticketrecognition.dto;

import java.util.Map;

public class MetadataDto {
    private Map<String, String> data;
    private String templateKey;

    public Map<String, String> getData() {
        return data;
    }

    public void setData(Map<String, String> data) {
        this.data = data;
    }

    public String getTemplateKey() {
        return templateKey;
    }

    public void setTemplateKey(String templateKey) {
        this.templateKey = templateKey;
    }
}
