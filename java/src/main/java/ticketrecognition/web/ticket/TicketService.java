package ticketrecognition.web.ticket;

import com.bfh.ticket.Metadata;
import com.bfh.ticket.TicketImage;
import com.bfh.ticket.TicketMatch;
import ticketrecognition.dto.MetadataDto;
import ticketrecognition.web.cti.TicketRecognitionService;

import javax.inject.Inject;
import java.io.IOException;
import java.io.InputStream;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Optional;
import java.util.Random;

public class TicketService {

    private static final DateTimeFormatter FORMATTER = DateTimeFormatter.ofPattern("YYYYMMddHHmmss");
    private static final Random RAND = new Random();

    private final TicketRecognitionService service;

    @Inject
    public TicketService(TicketRecognitionService service) {
        this.service = service;
    }

    MetadataDto match(InputStream stream) throws IOException {
        java.nio.file.Path targetPath = Paths.get(System.getProperty("java.io.tmpdir"), randomFileName());
        Files.copy(stream, targetPath, StandardCopyOption.REPLACE_EXISTING);
        TicketImage ticketImage = new TicketImage(targetPath.toAbsolutePath().toString());

        Optional<TicketMatch> matching = service.matcher().match(ticketImage);

        MetadataDto dto = new MetadataDto();
        if (matching.isPresent()) {
            Metadata metadata = service.reader().read(matching.get().getTicket(), ticketImage);
            dto.setData(metadata.getTexts());
        }
        return dto;
    }

    private String randomFileName() {
        return "TICKET_" + FORMATTER.format(LocalDateTime.now()) + "_" + Math.abs(RAND.nextInt());
    }
}
