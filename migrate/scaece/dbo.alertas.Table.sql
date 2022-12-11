/****** Object:  Table [dbo].[alertas]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[alertas](
	[id] [int] NOT NULL,
	[minimo_id] [int] NULL,
	[porcentaje] [decimal](8, 2) NOT NULL,
	[pedimento_id] [int] NULL
) ON [PRIMARY]

GO
