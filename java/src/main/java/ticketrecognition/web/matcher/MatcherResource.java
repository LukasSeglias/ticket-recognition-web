package ticketrecognition.web.matcher;

import com.bfh.ticket.Ticket;
import com.bfh.ticket.TicketImage;
import com.bfh.ticket.TicketMatch;
import ticketrecognition.Role;
import ticketrecognition.web.TicketRecognitionService;

import javax.annotation.security.RolesAllowed;
import javax.ejb.EJB;
import javax.ws.rs.Consumes;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.core.MediaType;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.Optional;

@Path("/matchers/")
@RolesAllowed({Role.AD_CODE, Role.SCANNER_CODE})
public class MatcherResource {

    private final String tempPath;
    private TicketRecognitionService service;

    public MatcherResource() {
        this.tempPath = System.getProperty("java.io.tmpdir");
    }

    @GET
    @Consumes(MediaType.APPLICATION_JSON)
    public TicketMatch get(TicketImage image) {
        Optional<TicketMatch> match = service.matcher().match(image);
        return match.orElse(null);
    }

    @POST
    @RolesAllowed({Role.AD_CODE})
    @Consumes(MediaType.APPLICATION_JSON)
    public void create(Ticket ticket) throws IOException {
        String filePath = findFile(ticket.getImage().getImagePath());
        service.matcher().train(new Ticket(ticket.getName(), new TicketImage(filePath), ticket.getTexts()));
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

    @EJB
    void setService(TicketRecognitionService service) {
        this.service = service;
    }
}
