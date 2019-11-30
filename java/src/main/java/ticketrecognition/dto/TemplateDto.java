package ticketrecognition.dto;

import java.util.List;

public class TemplateDto {
    private String name;
    private String fileName;
    private List<TextDto> texts;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getFileName() {
        return fileName;
    }

    public void setFileName(String fileName) {
        this.fileName = fileName;
    }

    public List<TextDto> getTexts() {
        return texts;
    }

    public void setTexts(List<TextDto> texts) {
        this.texts = texts;
    }
}
