package ticketrecognition.web.template;

import com.bfh.ticket.*;
import ticketrecognition.dto.TemplateDto;
import ticketrecognition.dto.TextDto;
import ticketrecognition.web.cti.TicketRecognitionService;

import javax.inject.Inject;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.List;
import java.util.stream.Collectors;

public class TemplateService {

    private final String tempPath;

    private final TicketRecognitionService service;

    @Inject
    public TemplateService(TicketRecognitionService service) {
        this.service = service;
        this.tempPath = System.getProperty("java.io.tmpdir");
    }

    void create(TemplateDto templateDto) throws IOException {
        String filePath = findFile(templateDto.getFileName());
        service.matcher().train(new Ticket(templateDto.getName(), new TicketImage(filePath), map(templateDto.getTexts())));
    }

    String findFile(String fileName) throws IOException {
        return Files.list(Paths.get(tempPath))
                .filter(file -> {
                    if (Files.isRegularFile(file)) {
                        return file.getFileName().toString().equals(fileName);
                    }
                    return false;
                })
                .map(java.nio.file.Path::toAbsolutePath)
                .map(java.nio.file.Path::toString)
                .findFirst()
                .orElse(null);
    }

    List<Text> map(List<TextDto> textDtos) {
        return textDtos.stream()
                .map(dto -> {
                    Point topLeft = new Point(dto.getTopLeft().getX(), dto.getTopLeft().getY());
                    Point bottomRight = new Point(dto.getBottomRight().getX(), dto.getBottomRight().getY());
                    BoundingBox boundingBox = new BoundingBox(topLeft, bottomRight);
                    return new Text(dto.getKey(), boundingBox);
                })
                .collect(Collectors.toList());
    }
}
