package ticketrecognition.web.ticket;

import com.bfh.ticket.Metadata;
import com.bfh.ticket.Ticket;
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
import java.util.logging.Logger;

public class TicketService {

    private static final Logger LOG = Logger.getLogger(TicketService.class.getName());

    private static final DateTimeFormatter FORMATTER = DateTimeFormatter.ofPattern("YYYYMMddHHmmss");
    private static final Random RAND = new Random();

    private final TicketRecognitionService service;

    @Inject
    public TicketService(TicketRecognitionService service) {
        this.service = service;
    }

    MetadataDto match(InputStream stream, String typeOfFile) throws IOException {
        java.nio.file.Path targetPath = Paths.get(System.getProperty("java.io.tmpdir"), randomFileName() + "." + typeOfFile);
        Files.copy(stream, targetPath, StandardCopyOption.REPLACE_EXISTING);
        LOG.info("File created: " + targetPath.toAbsolutePath().toString());
        TicketImage ticketImage = new TicketImage(targetPath.toAbsolutePath().toString());

        LOG.info("Do matching");
        Optional<TicketMatch> matching = service.matcher().match(ticketImage);
        LOG.info("Matching done. Found something: " + matching.isPresent());

        MetadataDto dto = new MetadataDto();
        if (matching.isPresent()) {
            LOG.info("Try to read information");
            Ticket ticket = matching.get().getTicket();
            Metadata metadata = service.reader().read(ticket, ticketImage);
            LOG.info("Finished reading");
            dto.setData(metadata.getTexts());
            dto.setTemplateKey(ticket.getName());
        }
        return dto;
    }

    private String randomFileName() {
        return "TICKET_" + FORMATTER.format(LocalDateTime.now()) + "_" + Math.abs(RAND.nextInt());
    }
}
